<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('key')->paginate(10);
        return view('admin.settings.index', compact('settings'));
    }

    public function create()
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key'   => 'required|string|max:100|unique:settings,key',
            'type'  => 'required|in:1,2',
            'value' => 'nullable|string',
            'file'  => 'nullable|file|max:10240',
            'note'  => 'nullable|string|max:255'
        ]);

        $value = null;

        // TYPE = TEXT
        if ($request->type == 1) {
            $value = $request->value;
        }

        // TYPE = FILE
        if ($request->type == 2 && $request->hasFile('file')) {
         
        $value = $this->uploadPublicFile($request, 'file', 'imgs/st');

        }

        Setting::create([
            'key'   => $request->key,
            'type'  => $request->type,
            'value' => $value,
            'note'  => $request->note,
        ]);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Thêm cấu hình thành công!');
    }

    public function edit(Setting $setting)
    {
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'value' => 'nullable|string',
            'file'  => 'nullable|file|max:10240',
            'note'  => 'nullable|string|max:255'
        ]);

        $value = $setting->value;

        // TYPE = TEXT
        if ($setting->type == 1) {
            $value = $request->value;
        }

        // TYPE = FILE
        if ($setting->type == 2 && $request->hasFile('file')) {
        $value = $this->uploadPublicFile($request, 'file', 'imgs/st');
        }

        $setting->update([
            'value' => $value,
            'note'  => $request->note,
        ]);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Cập nhật thành công!');
    }

    public function destroy(Setting $setting)
    {
        // Xóa file nếu là type file
        if ($setting->type == 2 && $setting->value && str_starts_with($setting->value, '/storage/')) {
            $path = str_replace('/storage/', '', $setting->value);
            Storage::disk('public')->delete($path);
        }

        $setting->delete();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Đã xóa cấu hình!');
    }

        private function uploadPublicFile($request, $inputName, $folder)
    {
        if (!$request->hasFile($inputName)) {
            return null;
        }

        $path = public_path($folder);

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $file = $request->file($inputName);
        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move($path, $filename);

        return '/' . trim($folder, '/') . '/' . $filename;
    }
}
