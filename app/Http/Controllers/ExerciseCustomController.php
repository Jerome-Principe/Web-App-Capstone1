<?php

namespace App\Http\Controllers;

use App\Models\ExerciseCustom;
use App\Models\PendingAppointment;
use Illuminate\Http\Request;

class ExerciseCustomController extends Controller
{
    public function index(Request $request)
    {
        $query = ExerciseCustom::with('user'); // Eager-load user relationship

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

        $exercisesCustom = $query->paginate(10);

        // Fetch approved users
        $approvedUsers = PendingAppointment::where('pending_appointments.status', 'Approved')
            ->join('pending_memberships', 'pending_appointments.user_id', '=', 'pending_memberships.id')
            ->select('pending_memberships.id as user_id', 'pending_memberships.first_name', 'pending_memberships.last_name')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->user_id => $item->first_name . ' ' . $item->last_name];
            });

        // Return view for web-based requests
        return view('exercise-custom', compact('exercisesCustom', 'approvedUsers'));
    }


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $approvedUsers = PendingAppointment::where('status', 'Approved')->pluck('user_id')->unique();
            view()->share('approvedUsers', $approvedUsers);

            return $next($request);
        });
    }

    public function exerciseCustomList()
    {
        $approvedUsers = PendingAppointment::where('status', 'Approved')->pluck('user_id')->unique();

        $exercisesCustom = ExerciseCustom::paginate(10);

        return view('exercise-custom', compact('exercisesCustom', 'approvedUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:pending_memberships,id',
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'guideline' => 'nullable|string',
            'exercise' => 'nullable|string',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:255',
        ]);

        ExerciseCustom::create($request->all());

        return redirect()->back()->with('success', 'Workout Program Custom item added successfully!');
    }

    public function edit($id)
    {
        $exerciseCustom = ExerciseCustom::with('user')->findOrFail($id);
        return view('exercise-custom-update', compact('exerciseCustom'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:pending_memberships,id',
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'guideline' => 'nullable|string',
            'exercise' => 'nullable|string',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:255',
        ]);

        $exerciseCustom = ExerciseCustom::findOrFail($id);
        $exerciseCustom->update($request->all());

        return redirect()->route('exercise-custom.index')->with('success', 'Exercise Custom updated successfully!');
    }

    public function destroy($id)
    {
        $exerciseCustom = ExerciseCustom::findOrFail($id);
        $exerciseCustom->delete();

        return redirect()->route('exercise-custom.index')->with('success', 'Exercise Custom deleted successfully!');
    }
}