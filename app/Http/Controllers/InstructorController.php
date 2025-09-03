<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
    public function index(Request $request)
    {
        // Order instructors by creation date, showing newest first
        $instructors = Instructor::orderBy('created_at', 'desc')->paginate(10); // Adjust the number per page as needed

        // Check if the request expects JSON
        if ($request->wantsJson()) {
            return response()->json($instructors);
        }

        // Otherwise, return the Blade view for web requests
        return view('instructor-list', compact('instructors'));
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'expertise' => 'nullable|string|max:255',
            'session' => 'nullable|string|max:255',
            'rates' => 'nullable|numeric',
        ]);

        $profileImagePath = null;

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = 'instructor_profile_' . time() . '.' . $image->getClientOriginalExtension();

            // Store the image in storage/app/public
            $storedPath = $image->storeAs('public', $imageName);

            if ($storedPath) {
                // Remove 'public/' from the path for database storage
                $profileImagePath = str_replace('public/', '', $storedPath);

                // Debug: Log the storage path
                \Log::info('Image stored at: ' . $storedPath);
                \Log::info('Database path: ' . $profileImagePath);
            } else {
                \Log::error('Failed to store image');
            }
        }

        // Create new instructor
        Instructor::create([
            'profile_image' => $profileImagePath,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'contact_number' => $request->input('contact_number'),
            'expertise' => $request->input('expertise'),
            'session' => $request->input('session'),
            'rates' => $request->input('rates'),
        ]);

        return redirect()->back()->with('success', 'Instructor created successfully!');
    }

    public function edit($id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('instructor-list', compact('instructor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'expertise' => 'nullable|string|max:255',
            'session' => 'nullable|string|max:255',
            'rates' => 'nullable|numeric',
        ]);

        $instructor = Instructor::findOrFail($id);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($instructor->profile_image) {
                Storage::delete('public/' . $instructor->profile_image);
            }

            $image = $request->file('profile_image');
            $imageName = 'instructor_profile_' . time() . '.' . $image->getClientOriginalExtension();

            // Store the image in storage/app/public
            $storedPath = $image->storeAs('public', $imageName);

            if ($storedPath) {
                // Remove 'public/' from the path for database storage
                $profileImagePath = str_replace('public/', '', $storedPath);

                // Debug: Log the storage path
                \Log::info('Image updated at: ' . $storedPath);
                \Log::info('Database path: ' . $profileImagePath);
            } else {
                \Log::error('Failed to store updated image');
            }

            $instructor->update([
                'profile_image' => $profileImagePath,
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'contact_number' => $request->input('contact_number'),
                'expertise' => $request->input('expertise'),
                'session' => $request->input('session'),
                'rates' => $request->input('rates'),
            ]);
        } else {
            // Update without changing the image
            $instructor->update($request->only([
                'first_name',
                'last_name',
                'contact_number',
                'expertise',
                'session',
                'rates'
            ]));
        }

        return redirect()->route('instructors.index')->with('success', 'Instructor updated successfully!');
    }

    public function destroy($id)
    {
        $instructor = Instructor::findOrFail($id);

        // Delete associated image file if exists
        if ($instructor->profile_image) {
            Storage::delete('public/' . $instructor->profile_image);
        }

        $instructor->delete();

        return redirect()->route('instructors.index')->with('success', 'Instructor deleted successfully!');
    }
    public function moveToTrash(Request $request)
    {
        // Get selected instructor IDs from the form
        $instructorIds = explode(',', $request->input('selected'));

        // Move instructors to trash
        Instructor::whereIn('id', $instructorIds)->delete();

        return redirect()->route('instructors.index')->with('success', 'Selected instructors moved to trash.');
    }

    public function trashed()
    {
        $trashedInstructors = Instructor::onlyTrashed()->paginate(10); // Use pagination
        return view('trashed-instructors', compact('trashedInstructors'));

    }
    public function restoreBulk(Request $request)
    {

        // Retrieve the selected instructor IDs from the form
        $instructorIds = explode(',', $request->input('selected'));

        // Restore the selected instructors
        Instructor::onlyTrashed()->whereIn('id', $instructorIds)->restore();

        return redirect()->route('instructors.trashed')->with('success', 'Instructors restored successfully.');
    }
    public function restore($id)
    {
        $instructor = Instructor::onlyTrashed()->findOrFail($id);
        $instructor->restore();

        return redirect()->route('instructors.trashed')->with('success', 'Instructor restored successfully.');
    }

    public function forceDelete($id)
    {
        $instructor = Instructor::onlyTrashed()->findOrFail($id);

        // Delete associated image file if exists
        if ($instructor->profile_image) {
            Storage::delete('public/' . $instructor->profile_image);
        }

        $instructor->forceDelete();

        return redirect()->route('instructors.trashed')->with('success', 'Instructor permanently deleted.');
    }
}
