<?php
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentDefectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WalkinController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\SaleItemController;
use App\Http\Controllers\StockItemController;
use App\Http\Controllers\MachineDefectController;
use App\Http\Controllers\MachineController;
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
use App\Http\Controllers\WorkoutProgramController;
use App\Http\Controllers\WorkoutProgramCustomController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseCustomController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\RFIDController;
use App\Http\Controllers\AttendanceRecordController;
use App\Http\Controllers\MobileFeedbackController;
use App\Http\Controllers\RegisterRFIDController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MembershipRenewalController;

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
Route::get('/status', function () {
    return view('status');
});

// dashboard
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

//Attendance
Route::resource('/rfid', RFIDController::class);

//Attendance Rercord List
Route::resource('/attendance-records', AttendanceRecordController::class);

//Attendance Rercord List
Route::resource('/register-rfid', RegisterRFIDController::class);

//Mobile Feedback
Route::resource('/mobile-feedback', MobileFeedbackController::class);

// Goal Routes
Route::prefix('goals')->name('goals.')->group(function () {
    // Main resource routes (excluding 'show')
    Route::get('/', [GoalController::class, 'index'])->name('index');
    Route::get('/create', [GoalController::class, 'create'])->name('create');
    Route::post('/', [GoalController::class, 'store'])->name('store');
    Route::get('/{goal}/edit', [GoalController::class, 'edit'])->name('edit');
    Route::put('/{goal}', [GoalController::class, 'update'])->name('update');
    Route::delete('/{goal}', [GoalController::class, 'destroy'])->name('destroy');

    // Additional custom routes using a controller group
    Route::controller(GoalController::class)->group(function () {
        Route::get('/trashed', 'trashed')->name('trashed');
        Route::post('/move-to-trash', 'moveToTrash')->name('moveToTrash');
        Route::post('/restoreBulk', 'restoreBulk')->name('restoreBulk');
        Route::post('/restore/{id}', 'restore')->name('restore');
        Route::delete('/forceDelete/{id}', 'forceDelete')->name('forceDelete');
    });
});

// Competition Routes
Route::prefix('competitions')->name('competitions.')->group(function () {
    // Main resource routes (excluding 'show')
    Route::get('/', [CompetitionController::class, 'index'])->name('index');
    Route::get('/create', [CompetitionController::class, 'create'])->name('create');
    Route::post('/', [CompetitionController::class, 'store'])->name('store');
    Route::get('/{competition}/edit', [CompetitionController::class, 'edit'])->name('edit');
    Route::put('/{competition}', [CompetitionController::class, 'update'])->name('update');
    Route::delete('/{competition}', [CompetitionController::class, 'destroy'])->name('destroy');

    // Additional custom routes using a controller group
    Route::controller(CompetitionController::class)->group(function () {
        Route::get('/trashed', 'trashed')->name('trashed');
        Route::post('/move-to-trash', 'moveToTrash')->name('moveToTrash');
        Route::post('/restoreBulk', 'restoreBulk')->name('restoreBulk');
        Route::post('/restore/{id}', 'restore')->name('restore');
        Route::delete('/forceDelete/{id}', 'forceDelete')->name('forceDelete');
    });
});

Route::get('/feedback', function () {
    return view('feedback');
});
Route::get('/inventory', function () {
    return view('inventory');
});

Route::get('/transaction', function () {
    return view('transaction');
});

// Feedback routes
Route::prefix('feedback')->name('feedback.')->group(function () {
    Route::resource('/', FeedbackController::class)->except(['show', 'edit', 'update']);
    Route::post('/submit', [FeedbackController::class, 'submit'])->name('submit');
    Route::post('/move-to-trash', [FeedbackController::class, 'moveToTrash'])->name('moveToTrash');
    Route::get('/trashed', [FeedbackController::class, 'trashed'])->name('trashed');
    Route::post('/restore-bulk', [FeedbackController::class, 'restoreBulk'])->name('restoreBulk');
    Route::post('/restore/{id}', [FeedbackController::class, 'restore'])->name('restore');
    Route::delete('/force-delete/{id}', [FeedbackController::class, 'forceDelete'])->name('forceDelete');
});

// Walk-in client routes
Route::prefix('walkin')->group(function () {
    Route::get('/', [WalkinController::class, 'create']);
    Route::get('/clients', [WalkinController::class, 'index'])->name('walkin.index');
    Route::post('/store', [WalkinController::class, 'store'])->name('walkin.store');
    Route::get('/{id}/edit', [WalkinController::class, 'edit'])->name('walkins.edit');
    Route::put('/{id}', [WalkinController::class, 'update'])->name('walkins.update');
    Route::delete('/{id}', [WalkinController::class, 'destroy'])->name('walkins.destroy');

    // Filter and Export routes
    Route::get('/filter', [WalkinController::class, 'filterByDate'])->name('walkin.filterByDate');
    Route::get('/export-pdf', [WalkinController::class, 'exportPdfByDate'])->name('walkin.exportPdfByDate');
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

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard route is already defined above with DashboardController

    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('updatePassword');
        Route::post('/delete', [ProfileController::class, 'destroy'])->name('delete');
    });

    // Registration
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
});



require __DIR__ . '/auth.php';


// Announcements
Route::resource('announcements', AnnouncementController::class);
Route::prefix('trashed-announcement')->name('announcements.')->group(function () {
    Route::post('/move-to-trash', [AnnouncementController::class, 'moveToTrash'])->name('moveToTrash');
    Route::get('/trashed', [AnnouncementController::class, 'trashed'])->name('trashed');
    Route::post('{id}/restore', [AnnouncementController::class, 'restore'])->name('restore');
    Route::delete('{id}/force-delete', [AnnouncementController::class, 'forceDelete'])->name('forceDelete');
    Route::post('/restore-bulk', [AnnouncementController::class, 'restoreBulk'])->name('restore.bulk');
});

//Instructors
Route::resource('instructors', InstructorController::class);

// Trashed Instructors Routes
Route::prefix('trashed-instructors')->name('instructors.')->group(function () {
    Route::post('/move-to-trash', [InstructorController::class, 'moveToTrash'])->name('moveToTrash');
    Route::get('/trashed', [InstructorController::class, 'trashed'])->name('trashed');
    Route::post('{id}/restore', [InstructorController::class, 'restore'])->name('restore');
    Route::delete('{id}/force-delete', [InstructorController::class, 'forceDelete'])->name('forceDelete');
    Route::post('/restore-bulk', [InstructorController::class, 'restoreBulk'])->name('restore.bulk');
});

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

// StockItems routes
Route::prefix('stock-items')->name('stock-items.')->group(function () {
    // Main resource routes (excluding 'show')
    Route::resource('/', StockItemController::class)
        ->parameters(['' => 'stock-item'])
        ->except(['show']);

    // Additional custom routes using a controller group
    Route::controller(StockItemController::class)->group(function () {
        Route::get('/filter', 'filterByDate')->name('filterByDate');
        Route::get('/export-pdf', 'exportPdfByDate')->name('exportPdfByDate');
    });
});

// SaleItems routes
Route::prefix('sales')->name('sales.')->group(function () {
    // Main resource routes (excluding 'show')
    Route::resource('/', SaleItemController::class)
        ->parameters(['' => 'sale'])
        ->except(['show']);

    // Additional custom routes using a controller group
    Route::controller(SaleItemController::class)->group(function () {
        Route::get('/filter', 'filterByDate')->name('filterByDate');
        Route::get('/export-pdf', 'exportPdfByDate')->name('exportPdfByDate');
    });
});

// EquipmentsAdd routes
Route::prefix('equipmentsAdd')->name('equipmentsAdd.')->group(function () {
    // Main resource routes
    Route::resource('/', EquipmentController::class)
        ->parameters(['' => 'equipments'])
        ->except(['show']);

    // Filter and Export routes
    Route::get('/filter', [EquipmentController::class, 'filterByDate'])->name('filterByDate');
    Route::get('/export-pdf', [EquipmentController::class, 'exportPdfByDate'])->name('exportPdfByDate');
});

// Machines routes
Route::prefix('machines')->name('machines.')->group(function () {
    // Main resource routes
    Route::resource('/', MachineController::class)
        ->parameters(['' => 'machines'])
        ->except(['show']);

    // Filter and Export routes
    Route::get('/filter', [MachineController::class, 'filterByDate'])->name('filterByDate');
    Route::get('/export-pdf', [MachineController::class, 'exportPdfByDate'])->name('exportPdfByDate');
});

// Equipments Defect routes
Route::prefix('equipments-defect')->name('equipments-defect.')->group(function () {
    // Main resource routes
    Route::resource('/', EquipmentDefectController::class)
        ->parameters(['' => 'equipments-defect'])
        ->except(['show']);

    // Filter and Export routes
    Route::get('/filter', [EquipmentDefectController::class, 'filterByDate'])->name('filterByDate');
    Route::get('/export-pdf', [EquipmentDefectController::class, 'exportPdfByDate'])->name('exportPdfByDate');
});

// Stock Items routes
Route::resource('stock-items', StockItemController::class);

// Machines Defect routes
Route::prefix('machine-defects')->name('machine-defects.')->group(function () {
    // Main resource routes
    Route::resource('/', MachineDefectController::class)
        ->parameters(['' => 'machine-defects'])
        ->except(['show']);

    // Filter and Export routes
    Route::get('/filter', [MachineDefectController::class, 'filterByDate'])->name('filterByDate');
    Route::get('/export-pdf', [MachineDefectController::class, 'exportPdfByDate'])->name('exportPdfByDate');
});

//Meal-plan
Route::resource('meal-plan', MealPlanController::class);

Route::resource('meal-plan-custom', MealPlanCustomController::class);
Route::get('/meal-plan-custom-list', [MealPlanCustomController::class, 'mealPlanCustomList'])->name('meal-plan-custom.list');

//Workout-Program
Route::resource('workout-programs', WorkoutProgramController::class);

Route::resource('workout-program-custom', WorkoutProgramCustomController::class);
Route::get('/workout-program-custom-list', [WorkoutProgramCustomController::class, 'workoutProgramCustomList'])->name('workout-program-custom.list');

//Exercise
Route::resource('exercise', ExerciseController::class);

Route::resource('exercise-custom', ExerciseCustomController::class);
Route::get('/exercise-custom-list', [ExerciseCustomController::class, 'exerciseCustomList'])->name('exercise-custom.list');

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

    // Filter and Export routes 
    Route::get('/list/filter', [MembershipPendingController::class, 'filterByDate'])->name('membership.list.filterByDate');
    Route::get('/list/export-pdf', [MembershipPendingController::class, 'exportPdfByDate'])->name('membership.list.exportPdfByDate');
});

Route::resource('membership-pendings', MembershipPendingController::class);
Route::post('/membership-pendings/{id}/approve', [MembershipPendingController::class, 'approve'])->name('membership-pendings.approve');
Route::post('/membership-pendings/{id}/decline', [MembershipPendingController::class, 'decline'])->name('membership-pendings.decline');
Route::post('/membership-pendings/destroy-all', [MembershipPendingController::class, 'destroyAll'])->name('membership-pendings.destroyAll');

// Membership Renewal Routes
Route::prefix('membership-renewal')->name('membership-renewal.')->group(function () {
    Route::get('/', [MembershipRenewalController::class, 'index'])->name('index');
    Route::post('/{id}/approve', [MembershipRenewalController::class, 'approve'])->name('approve');
    Route::post('/{id}/decline', [MembershipRenewalController::class, 'decline'])->name('decline');
    Route::get('/export-pdf', [MembershipRenewalController::class, 'exportPdf'])->name('export-pdf');
    Route::get('/filter', [MembershipRenewalController::class, 'filterByDate'])->name('filter');
    Route::post('/fix-types', [MembershipRenewalController::class, 'fixMembershipTypes'])->name('fix-types');
});

// Admin Users
Route::resource('admin-users', AdminUserController::class);

// Notifications API routes
Route::prefix('api/notifications')->name('notifications.')->group(function () {
    Route::get('/', [App\Http\Controllers\NotificationController::class, 'index'])->name('index');
    Route::post('/', [App\Http\Controllers\NotificationController::class, 'store'])->name('store');
    Route::get('/count', [App\Http\Controllers\NotificationController::class, 'getCount'])->name('count');
    Route::get('/recent', [App\Http\Controllers\NotificationController::class, 'getRecent'])->name('recent');
    Route::get('/{notification}', [App\Http\Controllers\NotificationController::class, 'show'])->name('show');
    Route::put('/{notification}', [App\Http\Controllers\NotificationController::class, 'update'])->name('update');
    Route::delete('/{notification}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('destroy');
    Route::post('/{notification}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('markAsRead');
    Route::post('/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
});

// Expenses routes
Route::prefix('expenses')->name('expenses.')->group(function () {
    // Main resource routes (excluding 'show')
    Route::resource('/', ExpenseController::class)
        ->parameters(['' => 'expense'])
        ->except(['show']);

    // Additional custom routes using a controller group
    Route::controller(ExpenseController::class)->group(function () {
        Route::get('/trashed', 'trashed')->name('trashed');
        Route::post('/move-to-trash', 'moveToTrash')->name('moveToTrash');
        Route::post('/restore-selected', 'restoreBulk')->name('restoreBulk');
        Route::post('/restore/{id}', 'restore')->name('restore');
        Route::delete('/force-delete/{id}', 'forceDelete')->name('forceDelete');
        Route::get('/filter', 'filterByDate')->name('filterByDate');
        Route::get('/export-pdf', 'exportPdfByDate')->name('exportPdfByDate');
    });
});