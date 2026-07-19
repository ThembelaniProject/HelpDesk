<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ActivityLogController;


/*
|--------------------------------------------------------------------------
| Welcome
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('users', UserController::class);

    Route::resource('categories', CategoryController::class);

    Route::resource('roles', RoleController::class);

});

/*
|--------------------------------------------------------------------------
| Ticket Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::resource('tickets', TicketController::class);

    Route::put(
        '/tickets/{ticket}/assign',
        [TicketController::class, 'assign']
    )->name('tickets.assign');

    Route::put(
        '/tickets/{ticket}/status',
        [TicketController::class, 'status']
    )->name('tickets.status');

});

/*
|--------------------------------------------------------------------------
| Comments
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post(
        '/comments',
        [CommentController::class, 'store']
    )->name('comments.store');

});

/*
|--------------------------------------------------------------------------
| Attachments
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post(
        '/tickets/{ticket}/attachments',
        [AttachmentController::class, 'store']
    )->name('attachments.store');

    Route::get(
        '/attachments/{attachment}/download',
        [AttachmentController::class, 'download']
    )->name('attachments.download');

    Route::delete(
        '/attachments/{attachment}',
        [AttachmentController::class, 'destroy']
    )->name('attachments.destroy');

});

/*
|--------------------------------------------------------------------------
| Technician
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'technician'])->group(function () {

    Route::get(
        '/technician/dashboard',
        [TechnicianController::class, 'index']
    )->name('technician.dashboard');

});

/*
|--------------------------------------------------------------------------
| Report
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','admin'])->group(function(){

    Route::get(
        '/reports',
        [ReportController::class,'index']
    )->name('reports.index');
    Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])
    ->name('reports.pdf');

Route::get('/reports/excel', [ReportController::class, 'exportExcel'])
    ->name('reports.excel');
});


/*
|--------------------------------------------------------------------------
| ActivityLog
|--------------------------------------------------------------------------
*/
Route::get('/activity-logs', [ActivityLogController::class, 'index'])
    ->name('activity.index');

require __DIR__.'/auth.php';