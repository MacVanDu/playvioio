<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

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
            'key' => 'required|string|max:100|unique:settings,key',
            'value' => 'nullable|string',
            'note' => 'nullable|string|max:255'
        ]);

        Setting::create($request->only(['key', 'value', 'note']));
        return redirect()->route('admin.settings.index')->with('success', 'Thêm cấu hình thành công!');
    }

    public function edit(Setting $setting)
    {
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'value' => 'nullable|string',
            'note' => 'nullable|string|max:255'
        ]);

        $setting->update($request->only(['value', 'note']));
        return redirect()->route('admin.settings.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->route('admin.settings.index')->with('success', 'Đã xóa cấu hình!');
    }
}
