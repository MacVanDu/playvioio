<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    protected $logPath;

    public function __construct()
    {
        $this->logPath = storage_path('logs');
    }

    public function index()
    {
        $files = collect(File::files($this->logPath))
            ->map(fn($f) => [
                'name' => $f->getFilename(),
                'size' => number_format($f->getSize() / 1024, 2) . ' KB',
                'last_modified' => date('d/m/Y H:i', $f->getMTime())
            ])
            ->sortByDesc('last_modified');

        return view('admin.logs.index', compact('files'));
    }

    public function show($filename)
    {
        $filePath = $this->logPath . '/' . $filename;
        if (!File::exists($filePath)) abort(404, 'Không tìm thấy file log.');

        $content = File::get($filePath);
        $content = nl2br(e($content)); // render HTML an toàn
        return view('admin.logs.show', compact('filename', 'content'));
    }

    public function download($filename)
    {
        $filePath = $this->logPath . '/' . $filename;
        if (!File::exists($filePath)) abort(404, 'Không tìm thấy file log.');

        return response()->download($filePath);
    }

    public function clear($filename)
    {
        $filePath = $this->logPath . '/' . $filename;
        if (!File::exists($filePath)) abort(404, 'Không tìm thấy file log.');

        File::put($filePath, '');
        return redirect()->route('admin.logs.index')->with('success', "Đã xóa nội dung file {$filename}");
    }

    public function destroy($filename)
    {
        $filePath = $this->logPath . '/' . $filename;
        if (!File::exists($filePath)) abort(404, 'Không tìm thấy file log.');

        File::delete($filePath);
        return redirect()->route('admin.logs.index')->with('success', "Đã xóa file {$filename}");
    }
}
