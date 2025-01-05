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
        $userId = $request->input('user_id');
        $category = $request->input('category');
        $type = $request->input('type');

        // Base query for MealPlanCustom with filtering
        $query = MealPlanCustom::query();

        if ($userId) {
            // Check if the user has an approved appointment
            $hasApprovedAppointment = PendingAppointment::where('user_id', $userId)
                ->where('status', 'Approved')
                ->exists();

            if ($hasApprovedAppointment) {
                $query->where('user_id', $userId);
            }
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($type) {
            $query->where('type', $type);
        }

        $mealPlanCustom = $query->get();

        if ($mealPlanCustom->isNotEmpty()) {
            return response()->json([
                'data' => $mealPlanCustom
            ], 200);
        }

        // Fallback to default meal plans with filtering
        $defaultQuery = MealPlan::query();

        if ($category) {
            $defaultQuery->where('category', $category);
        }

        if ($type) {
            $defaultQuery->where('type', $type);
        }

        $defaultMealPlans = $defaultQuery->get();

        return response()->json([
            'data' => $defaultMealPlans
        ], 200);
    }
}
