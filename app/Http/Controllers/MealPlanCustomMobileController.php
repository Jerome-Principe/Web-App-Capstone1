<?php

namespace App\Http\Controllers;

use App\Models\MealPlanCustom;
use App\Models\MealPlan;
use App\Models\PendingAppointment;
use Illuminate\Http\Request;

class MealPlanCustomMobileController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user_id;

        // Check if the user has an approved appointment
        $hasApprovedAppointment = PendingAppointment::where('user_id', $userId)
            ->where('status', 'Approved')
            ->exists();

        if ($hasApprovedAppointment) {
            // Fetch custom meal plans for the user
            $mealPlanCustom = MealPlanCustom::where('user_id', $userId)->get();

            if ($mealPlanCustom->isNotEmpty()) {
                return response()->json([
                    'data' => $mealPlanCustom
                ], 200);
            }
        }

        // Fallback to default meal plans if no custom meal plans exist
        $defaultMealPlans = MealPlan::get();

        return response()->json([
            'data' => $defaultMealPlans
        ], 200);
    }
}
