<?php

namespace App\Http\Controllers;

use App\Models\WorkoutProgramCustom;
use App\Models\PendingAppointment;
use Illuminate\Http\Request;

class WorkoutProgramCustomController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkoutProgramCustom::with('user'); // Eager-load user relationship

        // Apply filters if user_id, category, or type are provided
        if ($request->has('user_id') && $request->input('user_id') !== '') {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->has('category') && $request->input('category') !== '') {
            $query->where('category', $request->input('category'));
        }

        if ($request->has('type') && $request->input('type') !== '') {
            $query->where('type', $request->input('type'));
        }

        $workoutProgramsCustom = $query->paginate(10);

        // Fetch approved users
        $approvedUsers = PendingAppointment::where('pending_appointments.status', 'Approved')
            ->join('pending_memberships', 'pending_appointments.user_id', '=', 'pending_memberships.id')
            ->select('pending_memberships.id as user_id', 'pending_memberships.first_name', 'pending_memberships.last_name')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->user_id => $item->first_name . ' ' . $item->last_name];
            });

        // Return view for web-based requests
        return view('workout-program-custom', compact('workoutProgramsCustom', 'approvedUsers'));
    }


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $approvedUsers = PendingAppointment::where('status', 'Approved')->pluck('user_id')->unique();
            view()->share('approvedUsers', $approvedUsers);

            return $next($request);
        });
    }

    public function workoutProgramCustomList()
    {
        $approvedUsers = PendingAppointment::where('status', 'Approved')->pluck('user_id')->unique();

        // Assuming MealPlanCustom is the model for the Workout Program data
        $workoutProgramsCustom = WorkoutProgramCustom::paginate(10);

        return view('workout-program-custom', compact('workoutProgramsCustom', 'approvedUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:pending_memberships,id',
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'guideline' => 'nullable|string',
            'day' => 'nullable|string',
            'workout' => 'nullable|string',
            'difficulty' => 'required|string',
            'duration' => 'required|string',
        ]);

        WorkoutProgramCustom::create($request->all());

        return redirect()->back()->with('success', 'Workout Program Custom item added successfully!');
    }

    public function edit($id)
    {
        $workoutProgramCustom = WorkoutProgramCustom::with('user')->findOrFail($id);
        return view('workout-program-custom-update', compact('workoutProgramCustom'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:pending_memberships,id',
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'guideline' => 'nullable|string',
            'day' => 'nullable|string',
            'workout' => 'nullable|string',
            'difficulty' => 'required|string',
            'duration' => 'required|string',
        ]);

        $workoutProgramCustom = WorkoutProgramCustom::findOrFail($id);
        $workoutProgramCustom->update($request->all());

        return redirect()->route('workout-program-custom.index')->with('success', 'Workout Program Custom updated successfully!');
    }

    public function destroy($id)
    {
        $workoutProgramCustom = WorkoutProgramCustom::findOrFail($id);
        $workoutProgramCustom->delete();

        return redirect()->route('workout-program-custom.index')->with('success', 'Workout Program Custom deleted successfully!');
    }
}