<?php

namespace App\Http\Controllers;

use App\Models\MealPlanCustom;
use Illuminate\Http\Request;

class MealPlanCustomController extends Controller
{
    public function index(Request $request)
    {
        $query = MealPlanCustom::query();

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

        $mealPlansCustom = $query->paginate(10);

        // Check if the request expects a JSON response (API) or a view (web)
        if ($request->wantsJson()) {
            return response()->json(['data' => $mealPlansCustom]);
        }

        // Return view for web-based requests
        return view('meal-plan-custom', compact('mealPlansCustom'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'guideline' => 'nullable|string',
            'day' => 'nullable|string',
            'breakfast' => 'nullable|string',
            'lunch' => 'required|string',
            'dinner' => 'required|string',
        ]);

        MealPlanCustom::create($request->all());

        return redirect()->back()->with('success', 'Custom meal plan item added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
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

        return redirect()->route('meal-plan-custom.index')->with('success', 'Custom meal plan updated successfully!');
    }

    public function destroy($id)
    {
        $mealPlanCustom = MealPlanCustom::findOrFail($id);
        $mealPlanCustom->delete();

        return redirect()->route('meal-plan-custom.index')->with('success', 'Custom meal plan deleted successfully!');
    }
}