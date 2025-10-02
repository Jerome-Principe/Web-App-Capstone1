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
use App\Http\Controllers\MobilePasswordController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\MobileProfileController;
use App\Http\Controllers\MembershipRenewalController;
use App\Http\Controllers\NotificationController;

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

//OTP FOR SIGNUP
Route::post('/mobile/send-otp', [OtpController::class, 'sendOtp']);
Route::post('/mobile/verify-otp', [OtpController::class, 'verifyOtp']);

//OTP FOR RECOVERY
Route::post('/mobile/check-email', [RecoveryEmailController::class, 'checkEmail']);
Route::post('/mobile/send-recovery-otp', [RecoveryEmailController::class, 'sendRecoveryOtp']);
Route::post('/mobile/recovery-verify-otp', [RecoveryEmailController::class, 'verifyOtp']);
Route::post('/mobile/set-new-password', [RecoveryEmailController::class, 'setNewPassword']);

// Mobile Password Change Routes (Require Authentication)
Route::middleware('auth:api')->group(function () {
    Route::post('/mobile/change-password', [MobilePasswordController::class, 'changePassword']);
    Route::post('/mobile/verify-current-password', [MobilePasswordController::class, 'verifyCurrentPassword']);
    Route::get('/mobile/security-info', [MobilePasswordController::class, 'getSecurityInfo']);
});

Route::get('/mobile/rfid/user', [RFIDController::class, 'getAttendanceByUsername']);
Route::get('/mobile/rfid', [RFIDController::class, 'index']);
Route::post('/mobile/rfid', [RFIDController::class, 'store']);

Route::get('/mobile/membership-pendings', [MembershipPendingController::class, 'mGetMembershipPending']);
Route::post('/mobile/create-account', [MobileCreateAccountController::class, 'createAccount']);
Route::post('/mobile/login', [MobileCreateAccountController::class, 'login']);
Route::post('/mobile/logout', [MobileCreateAccountController::class, 'logout'])->middleware('auth:api');

// Profile Management API Routes
Route::post('/mobile/memberships', [RequestMembershipController::class, 'store']);
Route::middleware('auth:api')->get('/mobile/user-membership', [RequestMembershipController::class, 'getUserMembership']);
Route::middleware('auth:api')->get('/mobile/user-membership-details', [RequestMembershipController::class, 'getUserMembershipDetails']);
Route::middleware('auth:api')->put('/mobile/update-profile', [RequestMembershipController::class, 'updateProfile']);

Route::post('/mobile/medical-forms', [MedicalFormController::class, 'store']);

Route::post('/mobile/membership-payments', [MembershipPaymentController::class, 'store']);
Route::get('/mobile/membership-payments', [MembershipPaymentController::class, 'index']);

Route::post('/mobile/membership-renewals', [MembershipRenewalController::class, 'store']);
Route::get('/mobile/membership-renewals', [MembershipRenewalController::class, 'index']);

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
// Protect cancellation endpoint to ensure we use the authenticated user id
Route::middleware('auth:api')->post('mobile/cancelled', [CancelledAppointmentController::class, 'store']);
Route::get('mobile/cancelled', [CancelledAppointmentController::class, 'fetchCancelledAppointments']);

Route::get('/mobile/meal-plan-custom', [MealPlanCustomMobileController::class, 'index']);
Route::post('/mobile/meal-plan-custom', [MealPlanCustomController::class, 'store']);
Route::middleware('auth:api')->post('/mobile/meal-plan-complete', [MealPlanCustomMobileController::class, 'complete']);

Route::get('/mobile/workout-program-custom', [WorkoutProgramCustomMobileController::class, 'index']);
Route::post('/mobile/workout-program-custom', [WorkoutProgramCustomController::class, 'store']);
Route::middleware('auth:api')->post('/mobile/workout-program-complete', [WorkoutProgramCustomMobileController::class, 'complete']);

Route::get('/mobile/exercise-custom', [ExerciseCustomMobileController::class, 'index']);
Route::post('/mobile/exercise-custom', [ExerciseCustomController::class, 'store']);
Route::middleware('auth:api')->post('/mobile/exercise-complete', [ExerciseCustomMobileController::class, 'complete']);

Route::middleware('auth:api')->group(function () {
    Route::put('/membership-pendings/{id}/approve', [MembershipPendingController::class, 'approve']);
    Route::put('/membership-pendings/{id}/decline', [MembershipPendingController::class, 'decline']);
});

Route::middleware('auth:api')->get('/mobile/user', function (Request $request) {
    return response()->json([
        'id' => $request->user()->id,
        'name' => $request->user()->name,
        'email' => $request->user()->email,
        'profileImageUrl' => $request->user()->profile_picture ? url($request->user()->profile_picture) : null,
    ]);
});

// Mobile Profile Picture Routes
Route::middleware('auth:api')->group(function () {
    Route::post('/mobile/upload/profile-image', [MobileProfileController::class, 'uploadProfileImage']);
    Route::get('/mobile/profile', [MobileProfileController::class, 'getUserProfile']);
    Route::delete('/mobile/profile/image', [MobileProfileController::class, 'deleteProfileImage']);
});

// Announcement API Routes
Route::get('/mobile/announcements', [AnnouncementController::class, 'apiIndex']);
Route::get('/mobile/announcements/{id}', [AnnouncementController::class, 'apiShow']);
Route::middleware('auth:api')->post('/mobile/announcements', [AnnouncementController::class, 'apiStore']);
Route::middleware('auth:api')->put('/mobile/announcements/{id}', [AnnouncementController::class, 'apiUpdate']);
Route::middleware('auth:api')->delete('/mobile/announcements/{id}', [AnnouncementController::class, 'apiDestroy']);

// Notification API Routes
Route::post('/send-expiry-notifications', [NotificationController::class, 'sendExpiryNotifications']);
Route::get('/mobile/notifications', [NotificationController::class, 'getUserNotifications']);
Route::get('/mobile/notifications/count', [NotificationController::class, 'getCount']);
Route::middleware('auth:api')->post('/mobile/notifications/{id}/read', [NotificationController::class, 'markAsRead']);