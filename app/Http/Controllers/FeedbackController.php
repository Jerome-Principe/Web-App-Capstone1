<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // Display a paginated list of feedback
    public function index()
    {
        // Mark all feedback as read when accessing the feedback page
        Feedback::where('is_read', false)->update(['is_read' => true]);

        // Order feedback by creation date, showing newest first
        $feedback = Feedback::orderBy('created_at', 'desc')->paginate(10); // Retrieve 10 feedback entries per page
        return view('feedback', compact('feedback')); // Return view with feedback data
    }

    // Submit a new feedback entry
    public function submit(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Create a new feedback entry in the database
        $rating = $request->input('rating');

        // Debug: Log the rating being saved
        \Log::info('Feedback submission - Rating received: ' . $rating);

        Feedback::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'rating' => $rating,
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Feedback submitted successfully!');
    }

    // Display feedback list (same as index function, could be merged)
    function feedback()
    {
        // Mark all feedback as read when accessing the feedback page
        Feedback::where('is_read', false)->update(['is_read' => true]);

        $feedback = Feedback::orderBy('created_at', 'desc')->paginate(10); // Paginate feedback entries, sorted by most recent first
        return view('feedback', compact('feedback')); // Return view with feedback data
    }

    // Show a specific feedback entry
    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        return view('feedback-show', compact('feedback'));
    }

    // Show the form for creating a new feedback entry
    public function create()
    {
        return view('feedback-create');
    }

    // Store a newly created feedback entry
    public function store(Request $request)
    {
        return $this->submit($request);
    }

    // Delete a feedback entry
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('feedback.index')->with('success', 'Feedback deleted successfully!');
    }

    // Move selected feedback to trash (soft delete)
    public function moveToTrash(Request $request)
    {
        // Get the selected feedback IDs from the request
        $selectedIds = explode(',', $request->input('selected'));

        // Check if any feedback IDs are selected
        if (!empty($selectedIds)) {
            // Soft delete the selected feedback
            Feedback::whereIn('id', $selectedIds)->delete();

            // Redirect with success message
            return redirect()->route('feedback.index')->with('success', 'Selected feedback moved to trash.');
        }

        // Redirect with error message if no feedback selected
        return redirect()->back()->with('error', 'No feedback selected.');
    }

    // Display trashed (soft deleted) feedback entries
    public function trashed()
    {
        // Retrieve trashed feedback entries with pagination, sorted by most recent first
        $trashedFeedback = Feedback::onlyTrashed()->orderBy('created_at', 'desc')->paginate(10);
        return view('trashed-feedback', compact('trashedFeedback')); // Return view with trashed feedback data
    }

    // Restore a single feedback entry from the trash
    public function restore($id)
    {
        // Find the trashed feedback entry by ID
        $feedback = Feedback::onlyTrashed()->findOrFail($id);

        // Restore the feedback entry
        $feedback->restore();

        // Redirect with success message
        return redirect()->route('feedback.trashed')->with('success', 'Feedback restored successfully!');
    }

    // Restore multiple feedback entries from the trash
    public function restoreBulk(Request $request)
    {
        // Get the selected feedback IDs from the request
        $ids = $request->input('selected');

        // Check if any IDs are provided for restoration
        if ($ids) {
            // Restore the selected trashed feedback entries
            Feedback::onlyTrashed()->whereIn('id', explode(',', $ids))->restore();

            // Redirect with success message
            return redirect()->route('feedback.trashed')->with('success', 'Selected feedback restored successfully!');
        }

        // Redirect with error message if no feedback selected
        return redirect()->route('feedback.trashed')->with('error', 'No feedback selected for restoration.');
    }

    // Permanently delete a feedback entry from the trash
    public function forceDelete($id)
    {
        // Find the trashed feedback entry by ID
        $feedback = Feedback::onlyTrashed()->findOrFail($id);

        // Permanently delete the feedback entry
        $feedback->forceDelete();

        // Redirect with success message
        return redirect()->route('feedback.trashed')->with('success', 'Feedback permanently deleted!');
    }

    // Mark a specific feedback as read
    public function markAsRead($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->update(['is_read' => true]);

        return response()->json(['success' => true, 'message' => 'Feedback marked as read']);
    }
}
