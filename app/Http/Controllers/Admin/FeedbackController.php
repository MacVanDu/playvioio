<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameAndroid;
use App\Models\Feedbackff;

class FeedbackController extends Controller
{
      // Hiển thị danh sách feedback
    public function index()
    {
        $feedbacks = Feedbackff::orderBy('id', 'desc')->paginate(10);
        return view('admin.feedback.index', compact('feedbacks'));
    }

    // Xóa một feedback
    public function destroy($id)
    {
        $feedback = Feedbackff::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedback.index')->with('success', 'Đã xóa phản hồi thành công!');
    }
}
