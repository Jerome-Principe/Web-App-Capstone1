<?php

use App\Http\Controllers\MobileCreateAccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembershipPendingController;
use App\Http\Controllers\RequestMembershipController;
use App\Http\Controllers\MedicalFormController;
use App\Http\Controllers\MembershipPaymentController;
use App\Http\Controllers\PendingAppointmentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\CancelledAppointmentController;
use App\Http\Controllers\MealPlanCustomController;
use App\Http\Controllers\MealPlanCustomMobileController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\WorkoutProgramCustomController;
use App\Http\Controllers\WorkoutProgramCustomMobileController;
use App\Http\Controllers\ExerciseCustomController;
use App\Http\Controllers\ExerciseCustomMobileController;
use App\Http\Controllers\MobileFeedbackController;
use App\Http\Controllers\RFIDController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\RecoveryEmailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API ------
// routes sa api.php
// gagawa controller
// Test API in postman
// yung routes mo laging may /api sa umpisa

Route::post('/mobile/feedback', [MobileFeedbackController::class, 'store']);
Route::get('/mobile/feedback', [MobileFeedbackController::class, 'index']);

Route::get('/mobile/goals/user', [GoalController::class, 'getGoalsByUsername']);
Route::get('/mobile/goals', [GoalController::class, 'index']);
Route::post('/mobile/goals', [GoalController::class, 'store']);
Route::put('/mobile/goals/{goal}', [GoalController::class, 'update']);

Route::get('/mobile/competitions', [CompetitionController::class, 'index']);
Route::post('/mobile/competitions', [CompetitionController::class, 'store']);

Route::post('/mobile/check-email', [RecoveryEmailController::class, 'checkEmail']);

Route::get('/mobile/rfid/user', [RFIDController::class, 'getAttendanceByUsername']);
Route::get('/mobile/rfid', [RFIDController::class, 'index']);
Route::post('/mobile/rfid', [RFIDController::class, 'store']);

Route::get('/mobile/membership-pendings', [MembershipPendingController::class, 'mGetMembershipPending']);
Route::post('/mobile/create-account', [MobileCreateAccountController::class, 'createAccount']);
Route::post('/mobile/login', [MobileCreateAccountController::class, 'login']);
Route::post('/mobile/logout', [MobileCreateAccountController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/mobile/memberships', [RequestMembershipController::class, 'store']);
Route::middleware('auth:sanctum')->get('/mobile/user-membership', [RequestMembershipController::class, 'getUserMembership']);

Route::post('/mobile/medical-forms', [MedicalFormController::class, 'store']);

Route::post('/mobile/membership-payments', [MembershipPaymentController::class, 'store']);
Route::get('/mobile/membership-payments', [MembershipPaymentController::class, 'index']);

Route::post('/mobile/instructors', [InstructorController::class, 'store']);
Route::get('/mobile/instructors', [InstructorController::class, 'index']);

Route::get('/appointments', [PendingAppointmentController::class, 'index']);
Route::post('/mobile/appointments', [PendingAppointmentController::class, 'store']);
Route::get('/appointments/{id}', [PendingAppointmentController::class, 'show']);
Route::put('/appointments/{id}', [PendingAppointmentController::class, 'update']);
Route::delete('/mobile/appointments/{id}', [PendingAppointmentController::class, 'destroy']);
Route::patch('/appointments/{id}/approve', [PendingAppointmentController::class, 'approve']);
Route::patch('/appointments/{id}/decline', [PendingAppointmentController::class, 'decline']);

Route::get('mobile/appointments/list', [PendingAppointmentController::class, 'list']);
Route::post('mobile/cancelled', [CancelledAppointmentController::class, 'store']);
Route::get('mobile/cancelled', [CancelledAppointmentController::class, 'fetchCancelledAppointments']);

Route::get('/mobile/meal-plan-custom', [MealPlanCustomMobileController::class, 'index']);
Route::post('/mobile/meal-plan-custom', [MealPlanCustomController::class, 'store']);

Route::get('/mobile/workout-program-custom', [WorkoutProgramCustomMobileController::class, 'index']);
Route::post('/mobile/workout-program-custom', [WorkoutProgramCustomController::class, 'store']);

Route::get('/mobile/exercise-custom', [ExerciseCustomMobileController::class, 'index']);
Route::post('/mobile/exercise-custom', [ExerciseCustomController::class, 'store']);

//OTP
Route::post('/mobile/send-otp', [OtpController::class, 'sendOtp']);
Route::post('/mobile/verify-otp', [OtpController::class, 'verifyOtp']);

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/membership-pendings/{id}/approve', [MembershipPendingController::class, 'approve']);
    Route::put('/membership-pendings/{id}/decline', [MembershipPendingController::class, 'decline']);
});

Route::middleware('auth:sanctum')->get('/mobile/user', function (Request $request) {
    return response()->json([
        'id' => $request->user()->id,
        'name' => $request->user()->first_name . ' ' . $request->user()->last_name,
        'email' => $request->user()->email,
    ]);
});