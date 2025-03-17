<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    // Display all announcements
    public function index()
    {
        $announcements = Announcement::orderBy('id', 'desc')->paginate(3);
        return view('announcement', compact('announcements'));
    }

    // Show create form
    public function create()
    {
        return view('announcement-create');
    }

    // Store new announcement
    public function store(Request $request)
    {
        $request->validate([
            'notification_text' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $data = $request->only(['notification_text', 'description']);

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            $path = $request->file('pdf_file')->store('public/pdfs');
            $data['pdf_file'] = Storage::url($path);
        }

        Announcement::create($data);

        return redirect()->route('announcements.index')->with('success', 'Announcement created successfully!');
    }

    // Show specific announcement
    public function show(Announcement $announcement)
    {
        return view('announcement-show', compact('announcement'));
    }

    // Show edit form
    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return response()->json($announcement);
    }

    // Update announcement
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'notification_text' => 'required|string',
            'description' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $data = $request->only(['notification_text', 'description']);

        // Handle PDF upload and delete the old file if a new one is uploaded
        if ($request->hasFile('pdf_file')) {
            if ($announcement->pdf_file) {
                $oldPath = str_replace('/storage', 'public', $announcement->pdf_file);
                Storage::delete($oldPath);
            }
            $path = $request->file('pdf_file')->store('public/pdfs');
            $data['pdf_file'] = Storage::url($path);
        }

        $announcement->update($data);

        return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully!');
    }

    // Delete announcement
    public function destroy($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);

            // Delete associated PDF file if it exists
            if ($announcement->pdf_file) {
                $filePath = str_replace('/storage', 'public', $announcement->pdf_file);
                Storage::delete($filePath);
            }

            $announcement->delete();
            return redirect()->route('announcements.index')->with('success', 'Announcement deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete the announcement.');
        }
    }

    // Move selected announcements to trash (soft delete)
    public function moveToTrash(Request $request)
    {
        $announcementIds = explode(',', $request->input('selected'));
        Announcement::whereIn('id', $announcementIds)->delete();
        return redirect()->route('announcements.index')->with('success', 'Selected announcements moved to trash.');
    }

    // Display trashed announcements (soft deleted)
    public function trashed()
    {
        $trashedAnnouncements = Announcement::onlyTrashed()->paginate(10);
        return view('trashed-announcement', compact('trashedAnnouncements'));
    }

    // Restore selected announcements from trash (soft delete)
    public function restoreBulk(Request $request)
    {
        $announcementIds = explode(',', $request->input('selected'));
        if (empty($announcementIds)) {
            return back()->with('error', 'Please select at least one announcement to restore.');
        }

        try {
            Announcement::onlyTrashed()->whereIn('id', $announcementIds)->restore();
            return redirect()->route('announcements.trashed')->with('success', 'Selected announcements restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore selected announcements.');
        }
    }

    // Restore a single announcement from trash (soft delete)
    public function restore($id)
    {
        try {
            $announcement = Announcement::onlyTrashed()->findOrFail($id);
            $announcement->restore();
            return redirect()->route('announcements.trashed')->with('success', 'Announcement restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore the announcement.');
        }
    }

    // Permanently delete a single announcement from trash
    public function forceDelete($id)
    {
        try {
            $announcement = Announcement::onlyTrashed()->findOrFail($id);
            $announcement->forceDelete();
            return redirect()->route('announcements.trashed')->with('success', 'Announcement permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete the announcement.');
        }
    }
}
