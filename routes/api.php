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

Route::get('/mobile/membership-pendings', [MembershipPendingController::class, 'mGetMembershipPending']);
Route::post('/mobile/create-account', [MobileCreateAccountController::class, 'createAccount']);
Route::post('/mobile/login', [MobileCreateAccountController::class, 'login']);

Route::post('/mobile/memberships', [RequestMembershipController::class, 'store']);
Route::post('/mobile/medical-forms', [MedicalFormController::class, 'store']);

Route::post('/mobile/membership-payments', [MembershipPaymentController::class, 'store']);
Route::get('/mobile/membership-payments', [MembershipPaymentController::class, 'index']);

Route::get('/mobile/instructors', [InstructorController::class, 'getInstructors']);

Route::get('/appointments', [PendingAppointmentController::class, 'index']);
Route::post('/mobile/appointments', [PendingAppointmentController::class, 'store']);
Route::get('/appointments/{id}', [PendingAppointmentController::class, 'show']);
Route::put('/appointments/{id}', [PendingAppointmentController::class, 'update']);
Route::delete('/appointments/{id}', [PendingAppointmentController::class, 'destroy']);


Route::middleware('auth:sanctum')->group(function () {
    Route::put('/membership-pendings/{id}/approve', [MembershipPendingController::class, 'approve']);
    Route::put('/membership-pendings/{id}/decline', [MembershipPendingController::class, 'decline']);
});
