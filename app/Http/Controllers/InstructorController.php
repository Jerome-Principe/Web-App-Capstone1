<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index(Request $request)
    {
        $instructors = Instructor::paginate(10); // Pagination with 10 items per page

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
            'expertise' => 'nullable|string|max:255',
            'rates' => 'nullable|numeric',
        ]);

        // Create new instructor
        Instructor::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'expertise' => $request->expertise,
            'rates' => $request->rates,
        ]);

        return redirect()->back()->with('success', 'Instructor created successfully!');
    }
}
