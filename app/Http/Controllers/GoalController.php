<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::orderBy('id', 'desc')->paginate(10); // Order by newest ID first
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
            'current_weight' => 'required|numeric',
            'goal_weight' => 'required|numeric',
            'weekly_goal' => 'required|numeric',
            'activity' => 'required',
        ]);

        // Auto-assign status
        $status = $request->current_weight == $request->goal_weight ? 'Done' : 'In Progress';

        Goal::create([
            'status' => $status,
            'name' => $request->name,
            'starting_weight' => $request->starting_weight,
            'current_weight' => $request->current_weight,
            'goal_weight' => $request->goal_weight,
            'weekly_goal' => $request->weekly_goal,
            'activity' => $request->activity,
        ]);

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
            'current_weight' => 'required|numeric',
            'goal_weight' => 'required|numeric',
            'weekly_goal' => 'required|numeric',
            'activity' => 'required',
        ]);

        // Automatically update status
        $status = $request->current_weight == $request->goal_weight ? 'Done' : 'In Progress';

        $goal->update([
            'status' => $status,
            'name' => $request->name,
            'starting_weight' => $request->starting_weight,
            'current_weight' => $request->current_weight,
            'goal_weight' => $request->goal_weight,
            'weekly_goal' => $request->weekly_goal,
            'activity' => $request->activity,
        ]);

        return redirect()->route('goals.index')->with('success', 'Goal updated successfully!');
    }

    public function destroy(Goal $goal)
    {
        $goal->delete();
        return redirect()->route('goals.index')->with('success', 'Goal deleted successfully!');
    }

    public function getUserGoals(Request $request)
    {
        $username = $request->query('username');

        if (!$username) {
            return response()->json([
                'message' => 'Username is required.'
            ], 400);
        }

        $goals = Goal::where('name', $username)
            ->orderBy('id', 'desc') // Sort by latest first
            ->get();

        return response()->json([
            'data' => $goals
        ]);
    }
}
