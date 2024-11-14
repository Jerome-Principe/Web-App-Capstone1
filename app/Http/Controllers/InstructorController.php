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
