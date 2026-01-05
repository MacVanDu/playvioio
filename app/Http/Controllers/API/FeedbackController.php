<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameFeedback;
use App\Models\FeedbackPage;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    protected $file_log = 'game_index_bing';
    public function logss($log)
    {
        Log::channel($this->file_log)->info($log);
    }
    public function trackclick(Request $request)
    {
        $this->logss("click vao ok");
        return response()->json([
            'status' => true,
        ], 201);
    }
    public function store(Request $request)
    {
        // ✔ Validate dữ liệu gửi lên
        $validated = $request->validate([
            'name'            => 'nullable|string|max:255',
            'email'           => 'nullable|email|max:255',
            'message'         => 'required|string',
            'idGame'          => 'required|integer',
            'selectedSubject' => 'required|integer',
        ]);

        // ✔ Lưu vào DB
        $feedback = GameFeedback::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Feedback saved successfully',
            'data' => $feedback
        ], 201);
    }
        public function contact(Request $request)
    {
        // ✔ Validate dữ liệu gửi lên
        $validated = $request->validate([
            'email'           => 'nullable|email|max:255',
            'feedbackMessage'         => 'required|string',
            'feedbackSubject' => 'required|integer',
        ]);

        $feedback = Contact::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Feedback saved successfully',
            'data' => $feedback
        ], 201);
    }
        public function FeedbackPage(Request $request)
    {
        // ✔ Validate dữ liệu gửi lên
        $validated = $request->validate([
            'email'           => 'nullable|email|max:255',
            'feedbackMessage'         => 'required|string',
            'feedbackSubject' => 'required|integer',
        ]);

        $feedback = FeedbackPage::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Feedback saved successfully',
            'data' => $feedback
        ], 201);
    }
}
