<?php
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentDefectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WalkinController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\DrinkController;
use App\Http\Controllers\MachineDefectController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\SupplementController;
use App\Http\Controllers\MembershipPendingController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\RequestMembershipController;
use App\Http\Controllers\MedicalFormController;
use App\Http\Controllers\MembershipPaymentController;
use App\Http\Controllers\PendingAppointmentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\CancelledAppointmentController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\MealPlanCustomController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('fitdroid');
});
Route::get('/readmorebtn', function () {
    return view('readmorebtn');
});
Route::get('/learnmorebtn', function () {
    return view('learnmorebtn');
});

// dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/create-announcement', function () {
    return view('create-announcement');
});

Route::get('/all-announcement', function () {
    return view('all-announcement');
});

Route::get('/attendance', function () {
    return view('attendance');
});
Route::get('/feedback', function () {
    return view('feedback');
});
Route::get('/inventory', function () {
    return view('inventory');
});
Route::get('/maintenance', function () {
    return view('maintenance');
});
Route::get('/our-team', function () {
    return view('our-team');
});
Route::get('/transaction', function () {
    return view('transaction');
});

// Feedback routes
Route::prefix('feedback')->name('feedback.')->group(function () {
    Route::resource('/', FeedbackController::class)->except(['show']);
    Route::post('/submit', [FeedbackController::class, 'submit'])->name('submit');
    Route::post('/move-to-trash', [FeedbackController::class, 'moveToTrash'])->name('moveToTrash');
    Route::get('/trashed', [FeedbackController::class, 'trashed'])->name('trashed');
    Route::post('/restore-bulk', [FeedbackController::class, 'restoreBulk'])->name('restoreBulk');
    Route::post('/restore/{id}', [FeedbackController::class, 'restore'])->name('restore');
    Route::delete('/force-delete/{id}', [FeedbackController::class, 'forceDelete'])->name('forceDelete');
});

// Walk-in client routes
Route::prefix('walkin')->group(function () {
    Route::get('/filter', [WalkinController::class, 'filterByDate'])->name('walkin.filterByDate');
    Route::get('/export-pdf', [WalkinController::class, 'exportPdfByDate'])->name('walkin.exportPdfByDate');
    Route::get('/', [WalkinController::class, 'create']);
    Route::get('/clients', [WalkinController::class, 'index'])->name('walkin.index');
    Route::post('/store', [WalkinController::class, 'store'])->name('walkin.store');
    Route::get('/{id}/edit', [WalkinController::class, 'edit'])->name('walkins.edit');
    Route::put('/{id}', [WalkinController::class, 'update'])->name('walkins.update');
    Route::delete('/{id}', [WalkinController::class, 'destroy'])->name('walkins.destroy');
});

// Walk-in client trash-related routes
Route::prefix('walkins')->group(function () {
    Route::post('/move-to-trash', [WalkinController::class, 'moveToTrash'])->name('walkins.moveToTrash');
    Route::get('/trashed', [WalkinController::class, 'trashed'])->name('walkins.trashed');
    Route::post('/trashed/restore-bulk', [WalkinController::class, 'restoreBulk'])->name('walkins.restoreBulk');
    Route::post('/{id}/restore', [WalkinController::class, 'restore'])->name('walkins.restore');
    Route::delete('/{id}/force-delete', [WalkinController::class, 'forceDelete'])->name('walkins.forceDelete');
});


Route::get('/admin-users', [App\Http\Controllers\AdminUserController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
});



require __DIR__ . '/auth.php';


// Instructors
Route::resource('/instructors', InstructorController::class);
// Move to trash
Route::post('/instructors/move-to-trash', [InstructorController::class, 'moveToTrash'])->name('instructors.moveToTrash');
// Trashed instructors
Route::get('/trashed-instructors', [InstructorController::class, 'trashed'])->name('instructors.trashed');
// Restore instructor
Route::post('/instructors/{id}/restore', [InstructorController::class, 'restore'])->name('instructors.restore');
// Force delete instructor
Route::delete('/instructors/{id}/force-delete', [InstructorController::class, 'forceDelete'])->name('instructors.forceDelete');
// Restore bulk instructor
Route::post('/instructors/restore-bulk', [InstructorController::class, 'restoreBulk'])->name('instructors.restore.bulk');

// Pending Appointments Routes
Route::prefix('appointments')->group(function () {
    Route::get('/', [PendingAppointmentController::class, 'appointmentList'])->name('appointments.index');
    Route::get('/appointment-pending-list', [PendingAppointmentController::class, 'index'])->name('appointment-pending-list');
    Route::post('/store', [PendingAppointmentController::class, 'store'])->name('appointments.store');
    Route::patch('/{id}/approve', [PendingAppointmentController::class, 'approve'])->name('appointments.approve');
    Route::patch('/{id}/decline', [PendingAppointmentController::class, 'decline'])->name('appointments.decline');

    // Trash and Restore Routes
    Route::post('/move-to-trash', [PendingAppointmentController::class, 'moveToTrash'])->name('appointments.moveToTrash');
    Route::get('/trashed', [PendingAppointmentController::class, 'trashed'])->name('appointments.pending.trashed');
    Route::post('/restore-bulk', [PendingAppointmentController::class, 'restoreBulk'])->name('appointments.pending.restore.bulk');
    Route::post('/restore/{id}', [PendingAppointmentController::class, 'restore'])->name('appointments.pending.restore');
    Route::delete('/force-delete/{id}', [PendingAppointmentController::class, 'forceDelete'])->name('appointments.pending.forceDelete');
});

// Cancelled Appointments Routes
Route::prefix('cancelled')->group(function () {
    Route::get('/', [CancelledAppointmentController::class, 'index'])->name('appointments.cancelled');
    Route::post('/store', [CancelledAppointmentController::class, 'store'])->name('appointments.cancelled.store');
    Route::post('/move-to-trash', [CancelledAppointmentController::class, 'moveToTrash'])->name('appointments.cancelled.moveToTrash');
    Route::get('/trashed', [CancelledAppointmentController::class, 'trashed'])->name('appointments.cancelled.trashed');
    Route::post('/restore-bulk', [CancelledAppointmentController::class, 'restoreBulk'])->name('appointments.cancelled.restore.bulk');
    Route::post('/restore/{id}', [CancelledAppointmentController::class, 'restore'])->name('appointments.cancelled.restore');
    Route::delete('/force-delete/{id}', [CancelledAppointmentController::class, 'forceDelete'])->name('appointments.cancelled.forceDelete');
});

// Drinks routes
Route::prefix('drinks')->name('drinks.')->group(function () {
    // Main resource routes
    Route::resource('/', DrinkController::class)
        ->parameters(['' => 'drink'])
        ->except(['show']);

    // Additional routes
    Route::get('/trashed', [DrinkController::class, 'trashed'])->name('trashed');
    Route::post('/move-to-trash', [DrinkController::class, 'moveToTrash'])->name('moveToTrash');
    Route::post('/restore-bulk', [DrinkController::class, 'restoreBulk'])->name('restoreBulk');
    Route::post('/restore/{id}', [DrinkController::class, 'restore'])->name('restore');
    Route::delete('/force-delete/{id}', [DrinkController::class, 'forceDelete'])->name('forceDelete');

    // Filter and Export routes
    Route::get('/filter', [DrinkController::class, 'filterByDate'])->name('filterByDate');
    Route::get('/export-pdf', [DrinkController::class, 'exportPdfByDate'])->name('exportPdfByDate');
});

// Supplements routes
Route::prefix('supplements')->name('supplements.')->group(function () {
    // Main resource routes
    Route::resource('/', SupplementController::class)
        ->parameters(['' => 'supplement'])
        ->except(['show']);

    // Additional routes
    Route::get('/trashed', [SupplementController::class, 'trashed'])->name('trashed');
    Route::post('/move-to-trash', [SupplementController::class, 'moveToTrash'])->name('moveToTrash');
    Route::post('/restore-bulk', [SupplementController::class, 'restoreBulk'])->name('restoreBulk');
    Route::post('/restore/{id}', [SupplementController::class, 'restore'])->name('restore');
    Route::delete('/force-delete/{id}', [SupplementController::class, 'forceDelete'])->name('forceDelete');
});

// EquipmentsAdd routes
Route::prefix('equipmentsAdd')->name('equipmentsAdd.')->group(function () {
    // Main resource routes
    Route::resource('/', EquipmentController::class)
        ->parameters(['' => 'equipments'])
        ->except(['show']);

    // Additional routes
    Route::get('/trashed', [EquipmentController::class, 'trashed'])->name('trashed');
    Route::post('/move-to-trash', [EquipmentController::class, 'moveToTrash'])->name('moveToTrash');
    Route::post('/restore-bulk', [EquipmentController::class, 'restoreBulk'])->name('restoreBulk');
    Route::post('/restore/{id}', [EquipmentController::class, 'restore'])->name('restore');
    Route::delete('/force-delete/{id}', [EquipmentController::class, 'forceDelete'])->name('forceDelete');
});

// Machines routes
Route::prefix('machines')->name('machines.')->group(function () {
    // Main resource routes
    Route::resource('/', MachineController::class)
        ->parameters(['' => 'machines'])
        ->except(['show']);

    // Additional routes
    Route::get('/trashed', [MachineController::class, 'trashed'])->name('trashed');
    Route::post('/move-to-trash', [MachineController::class, 'moveToTrash'])->name('moveToTrash');
    Route::post('/restore-bulk', [MachineController::class, 'restoreBulk'])->name('restoreBulk');
    Route::post('/restore/{id}', [MachineController::class, 'restore'])->name('restore');
    Route::delete('/force-delete/{id}', [MachineController::class, 'forceDelete'])->name('forceDelete');
});

// Equipments Defect routes
Route::prefix('equipments-defect')->name('equipments-defect.')->group(function () {
    // Main resource routes
    Route::resource('/', EquipmentDefectController::class)
        ->parameters(['' => 'equipments-defect'])
        ->except(['show']);

    // Additional routes
    Route::get('/trashed', [EquipmentDefectController::class, 'trashed'])->name('trashed');
    Route::post('/move-to-trash', [EquipmentDefectController::class, 'moveToTrash'])->name('moveToTrash');
    Route::post('/restore-bulk', [EquipmentDefectController::class, 'restoreBulk'])->name('restoreBulk');
    Route::post('/restore/{id}', [EquipmentDefectController::class, 'restore'])->name('restore');
    Route::delete('/force-delete/{id}', [EquipmentDefectController::class, 'forceDelete'])->name('forceDelete');
});

// Machines Defect routes
Route::prefix('machine-defects')->name('machine-defects.')->group(function () {
    // Main resource routes
    Route::resource('/', MachineDefectController::class)
        ->parameters(['' => 'machine-defects'])
        ->except(['show']);

    // Additional routes
    Route::get('/trashed', [MachineDefectController::class, 'trashed'])->name('trashed');
    Route::post('/move-to-trash', [MachineDefectController::class, 'moveToTrash'])->name('moveToTrash');
    Route::post('/restore-bulk', [MachineDefectController::class, 'restoreBulk'])->name('restoreBulk');
    Route::post('/restore/{id}', [MachineDefectController::class, 'restore'])->name('restore');
    Route::delete('/force-delete/{id}', [MachineDefectController::class, 'forceDelete'])->name('forceDelete');
});

//Meal-plan
Route::resource('meal-plan', MealPlanController::class);

Route::resource('meal-plan-custom', MealPlanCustomController::class);
Route::get('/meal-plan-custom-list', [MealPlanCustomController::class, 'mealPlanCustomList'])->name('meal-plan-custom.list');

//Membership
Route::get('/membership-request-list', [RequestMembershipController::class, 'index']);
Route::get('/membership-emergency-medical', [MedicalFormController::class, 'index']);
Route::get('/membership-payment-list', [MembershipPaymentController::class, 'index']);

Route::prefix('membership-pendings')->group(function () {
    Route::get('/list', [MembershipPendingController::class, 'listApproved'])->name('membership.list');
    Route::get('/trashed', [MembershipPendingController::class, 'trashed'])->name('membership-pendings.trashed');
    Route::post('/move-to-trash', [MembershipPendingController::class, 'moveToTrash'])->name('membership-pendings.moveToTrash');
    Route::post('/{id}/restore', [MembershipPendingController::class, 'restore'])->name('membership-pendings.restore');
    Route::post('/restore-bulk', [MembershipPendingController::class, 'restoreBulk'])->name('membership-pendings.restoreBulk');
    Route::delete('/force-delete/{id}', [MembershipPendingController::class, 'forceDelete'])->name('membership-pendings.forceDelete');
});
Route::resource('membership-pendings', MembershipPendingController::class);
Route::post('/membership-pendings/{id}/approve', [MembershipPendingController::class, 'approve'])->name('membership-pendings.approve');
Route::post('/membership-pendings/{id}/decline', [MembershipPendingController::class, 'decline'])->name('membership-pendings.decline');
Route::post('/membership-pendings/destroy-all', [MembershipPendingController::class, 'destroyAll'])->name('membership-pendings.destroyAll');

// Admin Users
Route::resource('admin-users', AdminUserController::class);