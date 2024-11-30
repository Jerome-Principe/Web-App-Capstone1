<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index(Request $request)
    {
        // Use pagination instead of fetching all records
        $instructors = Instructor::paginate(10); // Adjust the number per page as needed

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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'expertise' => 'nullable|string|max:255',
            'session' => 'nullable|string|max:255',
            'rates' => 'nullable|numeric',
        ]);

        // Create new instructor
        Instructor::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact_number' => $request->contact_number,
            'expertise' => $request->expertise,
            'session' => $request->session,
            'rates' => $request->rates,
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'expertise' => 'nullable|string|max:255',
            'session' => 'nullable|string|max:255',
            'rates' => 'nullable|numeric',
        ]);

        $instructor = Instructor::findOrFail($id);
        $instructor->update($request->all());

        return redirect()->route('instructors.index')->with('success', 'Instructor updated successfully!');
    }

    public function destroy($id)
    {
        $instructor = Instructor::findOrFail($id);
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

        return redirect()->route('instructors.index')->with('success', 'Instructors restored successfully.');
    }
    public function restore($id)
    {
        $instructor = Instructor::onlyTrashed()->findOrFail($id);
        $instructor->restore();

        return redirect()->route('instructors.index')->with('success', 'Instructor restored successfully.');
    }

    public function forceDelete($id)
    {
        $instructor = Instructor::onlyTrashed()->findOrFail($id);
        $instructor->forceDelete();

        return redirect()->route('instructors.trashed')->with('success', 'Instructor permanently deleted.');
    }
}
