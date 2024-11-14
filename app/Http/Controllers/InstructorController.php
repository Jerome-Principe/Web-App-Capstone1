<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = Instructor::all();
        return view('instructor-list', compact('instructors'));
    }

    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'expertise' => 'nullable|string|max:255',
            'rates' => 'nullable|numeric',
        ]);

        // Create the new instructor record
        $instructor = Instructor::create($validated);

        // Return a success response
        return response()->json([
            'message' => 'Instructor created successfully!',
            'instructor' => $instructor,
        ], 201); // 201 Created status code
    }
}
