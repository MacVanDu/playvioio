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
            'ffmpegAvailable' => $this->ffmpegAvailable(),
        ]);
    }

    public function optimize(Request $request)
    {
        $data = $request->validate([
            'quality' => 'nullable|integer|min:40|max:95',
            'overwrite' => 'nullable|boolean',
        ]);

        if (!$this->ffmpegAvailable()) {
            return back()->with('error', 'Không tìm thấy ffmpeg trên server.');
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

            $process = new Process([
                'ffmpeg',
                '-hide_banner',
                '-loglevel',
                'error',
                '-y',
                '-i',
                $file->getPathname(),
                '-q:v',
                (string) $quality,
                '-compression_level',
                '6',
                $webpPath,
            ]);
            $process->setTimeout(120);
            $process->run();

            if (!$process->isSuccessful() || !File::exists($webpPath)) {
                $results['failed']++;
                $results['errors'][] = $file->getFilename() . ': ' . trim($process->getErrorOutput());
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
}
