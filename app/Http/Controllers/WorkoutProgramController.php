<?php

namespace App\Http\Controllers;

use App\Models\WorkoutProgram;
use Illuminate\Http\Request;

class WorkoutProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkoutProgram::query();

        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('category', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('type', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('guideline', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('day', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('workout', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('difficulty', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('duration', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Apply filters if category and type are provided
        if ($request->has('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }

        $workoutPrograms = $query->orderBy('id', 'desc')->paginate(10);

        // Append search parameter to pagination links
        if ($request->has('search')) {
            $workoutPrograms->appends(['search' => $request->search]);
        }

        // Check if the request expects a view (web) or JSON (API)
        if ($request->wantsJson()) {
            return response()->json(['data' => $workoutPrograms]);
        }

        // For web requests, return the view
        return view('workout-program', compact('workoutPrograms'));
    }

    public function store(Request $request)
    {
        // Insert Data into Database
        WorkoutProgram::create([
            'category' => $request->category,
            'type' => $request->type,
            'guideline' => $request->guideline,
            'day' => $request->day,
            'workout' => $request->workout,
            'difficulty' => $request->difficulty,
            'duration' => $request->duration,
        ]);

        return redirect()->back()->with('success', 'Workout Program Saved Successfully!');
    }

    public function edit($id)
    {
        $workoutProgram = WorkoutProgram::findOrFail($id);
        return view('workout-program-plan-update', compact('workoutProgram'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'guideline' => 'nullable|string',
            'day' => 'required|string|max:255',
            'workout' => 'nullable|string|max:65535',
            'difficulty' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
        ]);

        $workoutProgram = WorkoutProgram::findOrFail($id);
        $workoutProgram->update($request->all());

        return redirect()->route('workout-programs.index')->with('success', 'Workout Program updated successfully!');
    }

    public function destroy($id)
    {
        $workoutProgram = WorkoutProgram::findOrFail($id);
        $workoutProgram->delete();

        return redirect()->route('workout-programs.index')->with('success', 'Workout Program deleted successfully!');
    }

}
