<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScheduledCommand;
use Illuminate\Http\Request;

class ScheduledCommandController  extends Controller
{
  
    public function index()
    {
        $commands = ScheduledCommand::paginate(10);
        return view('admin.scheduled_commands.index', compact('commands'));
    }

public function create()
{
    return view('admin.scheduled_commands.create');
}

public function store(Request $request)
{
    $request->validate([
        'command' => 'required|string|max:255',
        'expression' => 'required|string|max:255',
        'time' => 'nullable|string|max:10',
        'enabled' => 'boolean',
    'note' => 'nullable|string|max:255',
    ]);

    ScheduledCommand::create($request->only(['command', 'expression', 'time', 'enabled','note']));

    return redirect()
        ->route('admin.scheduled-commands.index')
        ->with('success', 'Thêm command mới thành công!');
}
    public function edit(ScheduledCommand $scheduledCommand)
    {
        return view('admin.scheduled_commands.edit', compact('scheduledCommand'));
    }

    public function update(Request $request, ScheduledCommand $scheduledCommand)
    {
        $request->validate([
            'time' => 'nullable|string|max:10',
            'enabled' => 'boolean',
    'note' => 'nullable|string|max:255',
        ]);

        // Chỉ cho phép sửa giờ và bật/tắt
        $scheduledCommand->update($request->only(['time', 'enabled', 'note']));


        return redirect()->route('admin.scheduled-commands.index')->with('success', 'Cập nhật giờ chạy thành công.');
    }

    public function destroy(ScheduledCommand $scheduledCommand)
    {
        $scheduledCommand->delete();
        return back()->with('success', 'Đã xóa command.');
    }
}
