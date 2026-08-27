<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MobileFeedback;

class MobileFeedbackController extends Controller
{
    public function index()
    {
        $mobileFeedbacks = MobileFeedback::orderBy('created_at', 'desc')->paginate(10);
        $trashedCount = MobileFeedback::onlyTrashed()->count();
        return view('mobile-feedback', compact('mobileFeedbacks', 'trashedCount'));
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

    public function trashed()
    {
        $trashedMobileFeedbacks = MobileFeedback::onlyTrashed()->orderBy('created_at', 'desc')->paginate(10);
        $activeCount = MobileFeedback::count();
        return view('trashed-mobile-feedback', compact('trashedMobileFeedbacks', 'activeCount'));
    }

    public function moveToArchive(Request $request)
    {
        $selectedIds = $request->input('selected');

        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
        }

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'No feedback selected.');
        }

        MobileFeedback::whereIn('id', $selectedIds)->delete();

        return redirect()->route('mobile-feedback.index')->with('success', 'Selected feedback moved to archive successfully.');
    }

    public function restore($id)
    {
        $mobileFeedback = MobileFeedback::onlyTrashed()->findOrFail($id);
        $mobileFeedback->restore();

        return redirect()->route('mobile-feedback.trashed')->with('success', 'Feedback restored successfully.');
    }

    public function restoreBulk(Request $request)
    {
        $selectedIds = $request->input('selected');

        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
        }

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'No feedback selected.');
        }

        MobileFeedback::onlyTrashed()->whereIn('id', $selectedIds)->restore();

        return redirect()->route('mobile-feedback.trashed')->with('success', 'Selected feedback restored successfully.');
    }

    public function forceDelete($id)
    {
        $mobileFeedback = MobileFeedback::onlyTrashed()->findOrFail($id);
        $mobileFeedback->forceDelete();

        return redirect()->route('mobile-feedback.trashed')->with('success', 'Feedback permanently deleted successfully.');
    }
}
