<?php

namespace App\Http\Controllers;

use App\Models\MealPlanCustom;
use App\Models\MealPlan;
use Illuminate\Http\Request;

class MealPlanCustomMobileController extends Controller
{
    public function index(Request $request)
    {
        $mealPlanCustom = MealPlanCustom::where('user_id', $request->user_id)->get();

        $setMealPlan = null;

        if ($mealPlanCustom) {
            $setMealPlan = $mealPlanCustom;
        } else {
            $setMealPlan = MealPlan::get();
        }

        return response()->json([
            'data' => $setMealPlan
        ], 200);
    }

}
