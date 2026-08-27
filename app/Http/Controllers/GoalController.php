<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::orderBy('id', 'desc')->paginate(10); // Order by newest ID first

        // Check if the request expects JSON (API) or a view (web)
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $goals,
            ]);
        }

        // For web requests, return the view
        return view('goal', compact('goals'));
    }

    public function create()
    {
        return view('goals.create'); // You can create a separate view for goal creation
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'starting_weight' => 'required|numeric',
            'starting_date' => 'required|date',
            'current_weight' => 'required|numeric',
            'goal_weight' => 'required|numeric',
            'weekly_goal' => 'required|numeric',
            'activity' => 'required',
        ]);

        // Auto-assign status
        $status = $request->current_weight == $request->goal_weight ? 'Done' : 'In Progress';

        $goal = Goal::create([
            'status' => $status,
            'name' => $request->name,
            'starting_weight' => $request->starting_weight,
            'starting_date' => $request->starting_date,
            'current_weight' => $request->current_weight,
            'goal_weight' => $request->goal_weight,
            'weekly_goal' => $request->weekly_goal,
            'activity' => $request->activity,
        ]);

        // Check if the request expects JSON (API) or a view (web)
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Goal created successfully!',
                'data' => $goal,
            ]);
        }

        // For web requests, redirect back to the goals page with success message
        return redirect()->route('goals.index')->with('success', 'Goal created successfully!');
    }


    public function edit(Goal $goal)
    {
        return view('goals.edit', compact('goal')); // You can create this view too
    }

    public function update(Request $request, Goal $goal)
    {
        $request->validate([
            'name' => 'required',
            'starting_weight' => 'required|numeric',
            'starting_date' => 'required|date',
            'current_weight' => 'required|numeric',
            'goal_weight' => 'required|numeric',
            'weekly_goal' => 'required|numeric',
            'activity' => 'required',
        ]);

        $status = $request->current_weight == $request->goal_weight ? 'Done' : 'In Progress';

        $goal->update([
            'status' => $status,
            'name' => $request->name,
            'starting_weight' => $request->starting_weight,
            'starting_date' => $request->starting_date,
            'current_weight' => $request->current_weight,
            'goal_weight' => $request->goal_weight,
            'weekly_goal' => $request->weekly_goal,
            'activity' => $request->activity,
        ]);

        // Check if the request expects JSON (API) or a view (web)
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Goal updated successfully!',
                'data' => $goal,
            ]);
        }

        // For web requests, redirect back to the goals page with success message
        return redirect()->route('goals.index')->with('success', 'Goal updated successfully!');
    }

    public function destroy(Goal $goal)
    {
        $goal->delete();

        // Check if the request expects JSON (API) or a view (web)
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Goal deleted successfully!',
            ]);
        }

        // For web requests, redirect back to the goals page with success message
        return redirect()->route('goals.index')->with('success', 'Goal deleted successfully!');
    }

    public function moveToTrash(Request $request)
    {
        $selectedIds = $request->input('selected', '');

        if (empty($selectedIds)) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'No goals selected'], 400);
            }
            return redirect()->route('goals.index')->with('error', 'No goals selected for archiving.');
        }

        // Convert comma-separated string to array
        $selectedIdsArray = explode(',', $selectedIds);

        // Filter out empty values
        $selectedIdsArray = array_filter($selectedIdsArray);

        if (empty($selectedIdsArray)) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'No valid goals selected'], 400);
            }
            return redirect()->route('goals.index')->with('error', 'No valid goals selected for archiving.');
        }

        Goal::whereIn('id', $selectedIdsArray)->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Goals moved to archive successfully!',
            ]);
        }

        return redirect()->route('goals.index')->with('success', 'Goals moved to archive successfully!');
    }

    public function trashed()
    {
        $trashedGoals = Goal::onlyTrashed()->orderBy('id', 'desc')->paginate(10);
        return view('trashed-goals', compact('trashedGoals'));
    }

    public function restore($id)
    {
        $goal = Goal::onlyTrashed()->findOrFail($id);
        $goal->restore();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Goal restored successfully!',
            ]);
        }

        return redirect()->route('goals.trashed')->with('success', 'Goal restored successfully!');
    }

    public function restoreBulk(Request $request)
    {
        $selectedIds = explode(',', $request->selected);

        if (empty($selectedIds) || $selectedIds[0] === '') {
            return redirect()->route('goals.trashed')->with('error', 'No goals selected for restoration.');
        }

        Goal::onlyTrashed()->whereIn('id', $selectedIds)->restore();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Goals restored successfully!',
            ]);
        }

        return redirect()->route('goals.trashed')->with('success', 'Goals restored successfully!');
    }

    public function forceDelete($id)
    {
        $goal = Goal::onlyTrashed()->findOrFail($id);
        $goal->forceDelete();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Goal permanently deleted!',
            ]);
        }

        return redirect()->route('goals.trashed')->with('success', 'Goal permanently deleted!');
    }

    public function getGoalsByUsername(Request $request)
    {
        $username = $request->query('username'); // Get ?username= from query

        if (!$username) {
            return response()->json(['error' => 'Username is required'], 400);
        }

        // Filter goals where 'name' matches the username
        $goals = Goal::where('name', $username)->orderBy('id', 'desc')->get();

        return response()->json([
            'data' => $goals,
        ]);
    }
}
