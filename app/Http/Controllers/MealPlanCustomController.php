<?php

namespace App\Http\Controllers;

use App\Models\MealPlanCustom;
use App\Models\PendingAppointment;
use Illuminate\Http\Request;

class MealPlanCustomController extends Controller
{
    public function index(Request $request)
    {
        $query = MealPlanCustom::with('user');

        if ($request->has('user_id') && $request->input('user_id') !== '') {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->has('category') && $request->input('category') !== '') {
            $query->where('category', $request->input('category'));
        }

        if ($request->has('type') && $request->input('type') !== '') {
            $query->where('type', $request->input('type'));
        }

        $mealPlansCustom = $query->paginate(10);

        if ($mealPlansCustom->isEmpty()) {
            return response()->json(['data' => [], 'message' => 'No data found'], 200);
        }

        return view('meal-plan-custom', compact('mealPlansCustom', 'approvedUsers'));
    }


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $approvedUsers = PendingAppointment::where('status', 'Approved')->pluck('user_id')->unique();
            view()->share('approvedUsers', $approvedUsers);

            return $next($request);
        });
    }

    public function mealPlanCustomList()
    {
        $approvedUsers = PendingAppointment::where('status', 'Approved')->pluck('user_id')->unique();

        // Assuming MealPlanCustom is the model for the meal plan data
        $mealPlansCustom = MealPlanCustom::paginate(10);

        return view('meal-plan-custom', compact('mealPlansCustom', 'approvedUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:pending_memberships,id',
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'guideline' => 'nullable|string',
            'day' => 'nullable|string',
            'breakfast' => 'nullable|string',
            'lunch' => 'required|string',
            'dinner' => 'required|string',
        ]);

        MealPlanCustom::create($request->all());

        return redirect()->back()->with('success', 'Meal plan Custom item added successfully!');
    }

    public function edit($id)
    {
        $mealPlanCustom = MealPlanCustom::with('user')->findOrFail($id);
        return view('meal-plan-custom-update', compact('mealPlanCustom'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:pending_memberships,id',
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'guideline' => 'nullable|string',
            'day' => 'nullable|string',
            'breakfast' => 'nullable|string',
            'lunch' => 'required|string',
            'dinner' => 'required|string',
        ]);

        $mealPlanCustom = MealPlanCustom::findOrFail($id);
        $mealPlanCustom->update($request->all());

        return redirect()->route('meal-plan-custom.index')->with('success', 'Meal plan updated successfully!');
    }

    public function destroy($id)
    {
        $mealPlanCustom = MealPlanCustom::findOrFail($id);
        $mealPlanCustom->delete();

        return redirect()->route('meal-plan-custom.index')->with('success', 'Meal plan deleted successfully!');
    }
}
