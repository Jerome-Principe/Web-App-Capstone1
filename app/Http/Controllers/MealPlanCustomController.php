<?php

namespace App\Http\Controllers;

use App\Models\MealPlanCustom;
use Illuminate\Http\Request;

class MealPlanCustomController extends Controller
{
    public function index()
    {
        $mealPlansCustom = MealPlanCustom::paginate(10);
        return view('meal-plan-custom', compact('mealPlansCustom'));
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

        MealPlanCustom::create($request->all());

        return redirect()->back()->with('success', 'Meal plan Custom item added successfully!');
    }

    public function edit($id)
    {
        $mealPlanCustom = MealPlanCustom::findOrFail($id);
        return view('meal-plan-custom-update', compact('mealPlanCustom'));
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