<?php

namespace App\Http\Controllers;

use App\Models\MealPlan;
use Illuminate\Http\Request;

class MealPlanController extends Controller
{
    public function index(Request $request)
    {
        $query = MealPlan::query();

        if ($request->has('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }

        $mealPlans = $query->paginate(10);

        return response()->json(['data' => $mealPlans]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'guideline' => 'nullable|string',
            'day' => 'nullable|string',
            'breakfast' => 'nullable|string',
            'lunch' => 'required|string',
            'dinner' => 'required|string',
        ]);

        MealPlan::create($request->all());

        return redirect()->back()->with('success', 'Meal plan item added successfully!');
    }

    public function edit($id)
    {
        $mealPlan = MealPlan::findOrFail($id);
        return view('meal-plan-update', compact('mealPlan'));  // Create an 'edit' view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'guideline' => 'nullable|string',
            'day' => 'nullable|string',
            'breakfast' => 'nullable|string',
            'lunch' => 'required|string',
            'dinner' => 'required|string',
        ]);

        $mealPlan = MealPlan::findOrFail($id);
        $mealPlan->update($request->all());

        return redirect()->route('meal-plan.index')->with('success', 'Meal plan updated successfully!');
    }

    public function destroy($id)
    {
        $mealPlan = MealPlan::findOrFail($id);
        $mealPlan->delete();

        return redirect()->route('meal-plan.index')->with('success', 'Meal plan deleted successfully!');
    }
}
