<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index(Request $request)
    {
        $query = Exercise::query();

        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('category', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('type', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('guideline', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('exercise', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%")
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

        $exercises = $query->orderBy('id', 'desc')->paginate(10);

        // Append search parameter to pagination links
        if ($request->has('search')) {
            $exercises->appends(['search' => $request->search]);
        }

        // Check if the request expects a view (web) or JSON (API)
        if ($request->wantsJson()) {
            return response()->json(['data' => $exercises]);
        }

        // For web requests, return the view
        return view('exercise', compact('exercises'));
    }

    public function store(Request $request)
    {
        // Insert Data into Database
        Exercise::create([
            'category' => $request->category,
            'type' => $request->type,
            'guideline' => $request->guideline,
            'exercise' => $request->exercise,
            'description' => $request->description ?? null,
            'duration' => $request->duration,
        ]);

        return redirect()->back()->with('success', 'Exercise Saved Successfully!');
    }

    public function edit($id)
    {
        $exercise = Exercise::findOrFail($id);
        return view('exercise-update', compact('exercise'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'guideline' => 'nullable|string',
            'exercise' => 'nullable|string',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:255',
        ]);

        $exercise = Exercise::findOrFail($id);
        $exercise->update($request->all());

        return redirect()->route('exercise.index')->with('success', 'Exercise updated successfully!');
    }

    public function destroy($id)
    {
        $exercise = Exercise::findOrFail($id);
        $exercise->delete();

        return redirect()->route('exercise.index')->with('success', 'Exercise deleted successfully!');
    }

}
