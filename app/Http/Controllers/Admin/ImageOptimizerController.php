<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class ImageOptimizerController extends Controller
{
    private array $folders = [
        'imgs/g',
        'imgs/c',
        'imgs/st',
    ];

    public function index()
    {
        return view('admin.image-optimizer.index', [
            'stats' => $this->stats(),
            'folders' => $this->folders,
            'imageEngine' => $this->availableEngine(),
        ]);
    }

    public function optimize(Request $request)
    {
        $data = $request->validate([
            'quality' => 'nullable|integer|min:40|max:95',
            'overwrite' => 'nullable|boolean',
        ]);

        $engine = $this->availableEngine();

        if (!$engine) {
            return back()->with('error', 'Server cần có ffmpeg, Imagick hoặc PHP GD để nén ảnh WebP.');
        }

        $quality = $data['quality'] ?? 75;
        $overwrite = $request->boolean('overwrite');
        $results = [
            'created' => 0,
            'skipped' => 0,
            'failed' => 0,
            'before' => 0,
            'after' => 0,
            'errors' => [],
        ];

        foreach ($this->sourceFiles() as $file) {
            $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file->getPathname());

            if (!$overwrite && File::exists($webpPath)) {
                $results['skipped']++;
                continue;
            }

            $results['before'] += $file->getSize();

            $error = null;

            if (!$this->convertToWebp($file->getPathname(), $webpPath, $quality, $engine, $error)) {
                $results['failed']++;
                $results['errors'][] = $file->getFilename() . ': ' . $error;
                continue;
            }

            $results['created']++;
            $results['after'] += File::size($webpPath);
        }

        return back()->with('success', 'Đã nén ảnh xong.')->with('results', $results);
    }

    private function stats(): array
    {
        $sourceCount = 0;
        $webpCount = 0;
        $sourceBytes = 0;
        $webpBytes = 0;

        foreach ($this->sourceFiles() as $file) {
            $sourceCount++;
            $sourceBytes += $file->getSize();
        }

        foreach ($this->webpFiles() as $file) {
            $webpCount++;
            $webpBytes += $file->getSize();
        }

        return compact('sourceCount', 'webpCount', 'sourceBytes', 'webpBytes');
    }

    private function sourceFiles(): array
    {
        return $this->files('/\.(jpe?g|png)$/i');
    }

    private function webpFiles(): array
    {
        return $this->files('/\.webp$/i');
    }

    private function files(string $pattern): array
    {
        $files = [];

        foreach ($this->folders as $folder) {
            $path = public_path($folder);

            if (!File::isDirectory($path)) {
                continue;
            }

            foreach (File::allFiles($path) as $file) {
                if (preg_match($pattern, $file->getFilename())) {
                    $files[] = $file;
                }
            }
        }

        return $files;
    }

    private function ffmpegAvailable(): bool
    {
        $process = new Process(['ffmpeg', '-version']);
        $process->setTimeout(10);
        $process->run();

        return $process->isSuccessful();
    }

    private function availableEngine(): ?string
    {
        if ($this->ffmpegAvailable()) {
            return 'ffmpeg';
        }

        if (extension_loaded('imagick') && class_exists(\Imagick::class)) {
            return 'imagick';
        }

        if (function_exists('imagewebp') && function_exists('imagecreatefromjpeg') && function_exists('imagecreatefrompng')) {
            return 'gd';
        }

        return null;
    }

    private function convertToWebp(string $sourcePath, string $webpPath, int $quality, string $engine, ?string &$error): bool
    {
        if ($engine === 'ffmpeg') {
            return $this->convertWithFfmpeg($sourcePath, $webpPath, $quality, $error);
        }

        if ($engine === 'imagick') {
            return $this->convertWithImagick($sourcePath, $webpPath, $quality, $error);
        }

        return $this->convertWithGd($sourcePath, $webpPath, $quality, $error);
    }

    private function convertWithFfmpeg(string $sourcePath, string $webpPath, int $quality, ?string &$error): bool
    {
        $process = new Process([
            'ffmpeg',
            '-hide_banner',
            '-loglevel',
            'error',
            '-y',
            '-i',
            $sourcePath,
            '-q:v',
            (string) $quality,
            '-compression_level',
            '6',
            $webpPath,
        ]);
        $process->setTimeout(120);
        $process->run();

        if (!$process->isSuccessful() || !File::exists($webpPath)) {
            $error = trim($process->getErrorOutput()) ?: 'ffmpeg convert failed';
            return false;
        }

        return true;
    }

    private function convertWithImagick(string $sourcePath, string $webpPath, int $quality, ?string &$error): bool
    {
        try {
            $image = new \Imagick($sourcePath);
            $image->setImageFormat('webp');
            $image->setImageCompressionQuality($quality);
            $image->writeImage($webpPath);
            $image->clear();
            $image->destroy();
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            return false;
        }

        if (!File::exists($webpPath)) {
            $error = 'Imagick did not create WebP file';
            return false;
        }

        return true;
    }

    private function convertWithGd(string $sourcePath, string $webpPath, int $quality, ?string &$error): bool
    {
        $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));

        if (in_array($extension, ['jpg', 'jpeg'], true)) {
            $image = @imagecreatefromjpeg($sourcePath);
        } elseif ($extension === 'png') {
            $image = @imagecreatefrompng($sourcePath);

            if ($image) {
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
            }
        } else {
            $image = false;
        }

        if (!$image) {
            $error = 'GD cannot read image';
            return false;
        }

        $success = imagewebp($image, $webpPath, $quality);
        imagedestroy($image);

        if (!$success || !File::exists($webpPath)) {
            $error = 'GD convert failed';
            return false;
        }

        return true;
    }
}
