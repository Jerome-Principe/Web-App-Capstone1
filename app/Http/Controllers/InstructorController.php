<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
    public function index(Request $request)
    {
        $query = Instructor::query();

        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('contact_number', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('expertise', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('session', 'LIKE', "%{$searchTerm}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$searchTerm}%"]);
            });
        }

        // Order instructors by creation date, showing newest first
        $instructors = $query->orderBy('created_at', 'desc')->paginate(10);

        // Append search parameter to pagination links
        if ($request->has('search')) {
            $instructors->appends(['search' => $request->search]);
        }

        // Check if the request expects JSON
        if ($request->wantsJson()) {
            return response()->json($instructors);
        }

        // Otherwise, return the Blade view for web requests
        return view('instructor-list', compact('instructors'));
    }

    public function store(Request $request)
    {
        // Debug: Log the incoming request
        \Log::info('Instructor store request received', [
            'data' => $request->except('profile_image'),
            'has_file' => $request->hasFile('profile_image')
        ]);

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

            // Validate the image
            if (!$image->isValid()) {
                \Log::error('Invalid image file uploaded');
                return redirect()->back()->with('error', 'Invalid image file. Please try again.');
            }

            $imageName = 'instructor_profile_' . time() . '.' . $image->getClientOriginalExtension();

            // Log upload attempt
            \Log::info('Attempting to upload image: ' . $imageName);
            \Log::info('Image size: ' . $image->getSize() . ' bytes');
            \Log::info('Image mime type: ' . $image->getMimeType());

            try {
                // Store the image in storage/app/public/instructor_profile folder
                $storedPath = $image->storeAs('public/instructor_profile', $imageName);

                if ($storedPath) {
                    // Remove 'public/' from the path for database storage
                    $profileImagePath = str_replace('public/', '', $storedPath);

                    // Verify the file was actually created
                    $fullPath = storage_path('app/public/instructor_profile/' . $imageName);
                    if (file_exists($fullPath)) {
                        \Log::info('Image successfully stored at: ' . $storedPath);
                        \Log::info('Database path: ' . $profileImagePath);
                        \Log::info('Full file path: ' . $fullPath);
                        \Log::info('File size on disk: ' . filesize($fullPath) . ' bytes');
                    } else {
                        \Log::error('Image was not found on disk after upload: ' . $fullPath);
                        return redirect()->back()->with('error', 'Failed to upload image. Please try again.');
                    }
                } else {
                    \Log::error('Failed to store image - storeAs returned false');
                    return redirect()->back()->with('error', 'Failed to upload image. Please try again.');
                }
            } catch (\Exception $e) {
                \Log::error('Exception during image upload: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload image: ' . $e->getMessage());
            }
        }



        // Create new instructor
        $instructor = Instructor::create([
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

            // Store the image in storage/app/public/instructor_profile folder
            $storedPath = $image->storeAs('public/instructor_profile', $imageName);

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

    public function trashed(Request $request)
    {
        $query = Instructor::onlyTrashed();

        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('contact_number', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('expertise', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('session', 'LIKE', "%{$searchTerm}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$searchTerm}%"]);
            });
        }

        $trashedInstructors = $query->paginate(10); // Use pagination

        // Append search parameter to pagination links
        if ($request->has('search')) {
            $trashedInstructors->appends(['search' => $request->search]);
        }

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
