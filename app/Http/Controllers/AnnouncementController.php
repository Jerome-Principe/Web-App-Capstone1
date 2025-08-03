<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

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
            $data['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
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

        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->store('pdfs', 'public');
            $announcement->pdf_file = $pdfPath;
        }

        $announcement->notification_text = $request->notification_text;
        $announcement->description = $request->description;
        $announcement->save();

        return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully!');
    }

    // Delete announcement
    public function destroy($id)
    {
        $announcement = Announcement::find($id);
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Announcement deleted successfully!');
    }

    /**
     * Move selected announcements to trash (soft delete).
     */
    public function moveToTrash(Request $request)
    {
        // Get selected announcements IDs from the form
        $announcementIds = explode(',', $request->input('selected'));

        // Move announcements to trash
        Announcement::whereIn('id', $announcementIds)->delete();

        return redirect()->route('announcements.index')->with('success', 'Selected announcements moved to trash.');
    }

    /**
     * Display the trashed announcement (soft deleted).
     */
    public function trashed()
    {
        $trashedAnnouncements = Announcement::onlyTrashed()->paginate(10);
        return view('trashed-announcement', compact('trashedAnnouncements'));
    }

    /**
     * Restore selected announcement from trash (soft delete).
     */
    public function restoreBulk(Request $request)
    {
        $announcementIds = explode(',', $request->input('selected'));

        if (empty($announcementIds)) {
            return back()->with('error', 'Please select at least one Announcement to restore.');
        }

        try {
            Announcement::onlyTrashed()->whereIn('id', $announcementIds)->restore();
            return redirect()->route('announcements.trashed')->with('success', 'Selected Announcement restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore selected announcements.');
        }
    }

    /**
     * Restore a single announcement from trash (soft delete).
     */
    public function restore($id)
    {
        try {
            $announcement = Announcement::onlyTrashed()->findOrFail($id);
            $announcement->restore();
            return redirect()->route('announcements.trashed')->with('success', 'Announcement restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore the Announcement.');
        }
    }

    /**
     * Permanently delete a single announcement from trash.
     */
    public function forceDelete($id)
    {
        try {
            $announcement = Announcement::onlyTrashed()->findOrFail($id);
            $announcement->forceDelete();
            return redirect()->route('announcements.trashed')->with('success', 'Announcement permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete the Announcement.');
        }
    }

    // API Methods
    /**
     * Get all announcements for API
     */
    public function apiIndex()
    {
        try {
            $announcements = Announcement::orderBy('created_at', 'desc')->get();

            // Return array directly for mobile app compatibility
            return response()->json($announcements);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve announcements',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific announcement for API
     */
    public function apiShow($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);

            return response()->json($announcement);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Announcement not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Store new announcement via API
     */
    public function apiStore(Request $request)
    {
        try {
            $request->validate([
                'notification_text' => 'required|string|max:255',
                'description' => 'nullable|string',
                'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
            ]);

            $data = $request->only(['notification_text', 'description']);

            // Handle PDF upload
            if ($request->hasFile('pdf_file')) {
                $data['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
            }

            $announcement = Announcement::create($data);

            return response()->json([
                'success' => true,
                'data' => $announcement,
                'message' => 'Announcement created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create announcement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update announcement via API
     */
    public function apiUpdate(Request $request, $id)
    {
        try {
            $announcement = Announcement::findOrFail($id);

            $request->validate([
                'notification_text' => 'required|string|max:255',
                'description' => 'nullable|string',
                'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
            ]);

            $data = $request->only(['notification_text', 'description']);

            // Handle PDF upload
            if ($request->hasFile('pdf_file')) {
                $data['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
            }

            $announcement->update($data);

            return response()->json([
                'success' => true,
                'data' => $announcement,
                'message' => 'Announcement updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update announcement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete announcement via API
     */
    public function apiDestroy($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            $announcement->delete();

            return response()->json([
                'success' => true,
                'message' => 'Announcement deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete announcement',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
