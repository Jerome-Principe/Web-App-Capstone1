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

        // Ensure user_id is provided
        if (!$userId) {
            return response()->json(['error' => 'User ID is required'], 400);
        }

        // Check if the user has an approved appointment
        $hasApprovedAppointment = PendingAppointment::where('user_id', $userId)
            ->where('status', 'Approved')
            ->exists();

        if ($hasApprovedAppointment) {
            // Fetch custom meal plans specific to the user
            $query = MealPlanCustom::where('user_id', $userId);

            if ($category) {
                $query->where('category', $category);
            }

            if ($type) {
                $query->where('type', $type);
            }

            $mealPlanCustom = $query->get();

            if ($mealPlanCustom->isNotEmpty()) {
                return response()->json(['data' => $mealPlanCustom], 200);
            }
        }

        // Fallback to default meal plans if no custom meal plans found
        $defaultQuery = MealPlan::query();

        if ($category) {
            $defaultQuery->where('category', $category);
        }

        if ($type) {
            $defaultQuery->where('type', $type);
        }

        $defaultMealPlans = $defaultQuery->get();

        return response()->json(['data' => $defaultMealPlans], 200);
    }

    public function complete(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'category' => 'required|string',
            'type' => 'required|string',
        ]);

        $userId = $request->input('user_id');
        $category = $request->input('category');
        $type = $request->input('type');

        try {
            // Update all meal plans for this user, category, and type to 'Completed'
            $updatedCount = MealPlanCustom::where('user_id', $userId)
                ->where('category', $category)
                ->where('type', $type)
                ->update(['progress' => 'Completed']);

            if ($updatedCount > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Meal plan marked as completed successfully',
                    'updated_count' => $updatedCount
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No meal plans found to update'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update meal plan progress',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
