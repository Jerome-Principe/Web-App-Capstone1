<?php

namespace App\Http\Controllers;

use App\Models\ExerciseCustom;
use App\Models\Exercise;
use App\Models\PendingAppointment;
use Illuminate\Http\Request;

class ExerciseCustomMobileController extends Controller
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
            // Fetch custom Workout Programs specific to the user
            $query = ExerciseCustom::where('user_id', $userId);

            if ($category) {
                $query->where('category', $category);
            }

            if ($type) {
                $query->where('type', $type);
            }

            $exercisesCustom = $query->get();

            if ($exercisesCustom->isNotEmpty()) {
                return response()->json(['data' => $exercisesCustom], 200);
            }
        }

        // Fallback to default Exercise if no custom Exercises found
        $defaultQuery = Exercise::query();

        if ($category) {
            $defaultQuery->where('category', $category);
        }

        if ($type) {
            $defaultQuery->where('type', $type);
        }

        $defaultExercises = $defaultQuery->get();

        return response()->json(['data' => $defaultExercises], 200);
    }

    public function complete(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'type' => 'required|string',
        ]);

        $userId = $request->user()->id;
        $category = $request->input('category');
        $type = $request->input('type');

        try {
            // Log the parameters for debugging
            \Log::info('Exercise complete request', [
                'user_id' => $userId,
                'category' => $category,
                'type' => $type
            ]);

            // Update all exercises for this user, category, and type to 'Completed'
            $updatedCount = ExerciseCustom::where('user_id', $userId)
                ->where('category', $category)
                ->where('type', $type)
                ->update(['progress' => 'Completed']);

            \Log::info('Exercise update result', ['updated_count' => $updatedCount]);

            if ($updatedCount > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Exercise marked as completed successfully',
                    'updated_count' => $updatedCount
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No exercises found to update'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update exercise progress',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
