<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MobileFeedback;

class MobileFeedbackController extends Controller
{
    public function index()
    {
        $mobileFeedbacks = MobileFeedback::paginate(10);
        return view('mobile-feedback', compact('mobileFeedbacks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        MobileFeedback::create($request->all());

        return redirect()->route('mobile-feedback.index')->with('success', 'Feedback submitted successfully.');
    }

    public function destroy($id)
    {
        $mobileFeedback = MobileFeedback::findOrFail($id);
        $mobileFeedback->delete();

        return redirect()->route('mobile-feedback.index')->with('success', 'Feedback deleted successfully.');
    }
}
