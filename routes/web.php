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


// Add these routes in your routes/web.php
Route::get('/feedback', [FeedbackController::class, 'feedback'])->name('feedback.index');
Route::post('/submit', [FeedbackController::class, 'submit'])->name('FeedbackSubmit');
Route::get('/feedback/{id}/edit', [FeedbackController::class, 'edit'])->name('feedback.edit');
Route::put('/feedback/update/{id}', [FeedbackController::class, 'update'])->name('feedback.update'); // Updated
Route::delete('/feedback/delete/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');


// Walkin-client
Route::get('/walkin', [WalkinController::class, 'create']);
Route::get('/walkin-clients', [WalkinController::class, 'index'])->name('walkin.index');
Route::post('/walkin/store', [WalkinController::class, 'store'])->name('walkin.store');
Route::get('/walkins/{id}/edit', [WalkinController::class, 'edit'])->name('walkins.edit');
Route::put('/walkins/{id}', [WalkinController::class, 'update'])->name('walkins.update');
Route::delete('/walkins/{id}', [WalkinController::class, 'destroy'])->name('walkins.destroy');


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
Route::resource('instructors', InstructorController::class);
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


//Meal-plan
Route::resource('meal-plan', MealPlanController::class);

Route::get('/machine', function () {
    return view('inventory-machine');
});

Route::get('/supplements', function () {
    return view('inventory-supplements');
});

Route::resource('equipmentsadd', EquipmentController::class);

Route::resource('drinks', DrinkController::class);

Route::resource('equipments', EquipmentDefectController::class);

Route::resource('machine-defects', MachineDefectController::class);

Route::resource('machines', MachineController::class);

route::resource('supplements', SupplementController::class);


//Membership

Route::get('/membership-request-list', [RequestMembershipController::class, 'index']);
Route::get('/membership-emergency-medical', [MedicalFormController::class, 'index']);

Route::get('/membership-payment-list', [MembershipPaymentController::class, 'index']);

Route::get('/membership-list', [MembershipPendingController::class, 'listApproved'])->name('membership.list');
Route::resource('membership-pendings', MembershipPendingController::class);
Route::post('/membership-pendings/{id}/approve', [MembershipPendingController::class, 'approve'])->name('membership-pendings.approve');
Route::post('/membership-pendings/{id}/decline', [MembershipPendingController::class, 'decline'])->name('membership-pendings.decline');
Route::post('/membership-pendings/destroy-all', [MembershipPendingController::class, 'destroyAll'])->name('membership-pendings.destroyAll');

// Admin Users
Route::resource('admin-users', AdminUserController::class);