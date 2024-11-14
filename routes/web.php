<?php

use App\Http\Controllers\Admin\LeaveRequestsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Employee\EmployeeDashboardController;
use App\Http\Controllers\Employee\EmployeeLeaveController;
use App\Http\Controllers\ProfileController;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:employee', 'permission:apply for leave|view leaves'])
->group(function () {
    Route::get('dashboard', [EmployeeDashboardController::class, 'index'])
            ->name('dashboard');

    Route::get('/employee/leave-request', [EmployeeDashboardController::class, 'createLeaveRequestForm'])
           ->name('leave.request.form');

    Route::post('/employee/leave', [EmployeeDashboardController::class, 'store'])
            ->name('leave.store');

    Route::get('/leave-requests/data', [EmployeeLeaveController::class, 'getData'])
            ->name('leave-requests.data');

});

Route::middleware(['auth', 'role:admin', 'permission:approve leaves|reject leaves|delete leaves|view leaves'])
->group(function () {
    Route::get('/admin/dashboard', [LeaveRequestsController::class, 'index'])
            ->name('admin.dashboard');

    Route::patch('/admin/dashboard/{id}/approve', [LeaveRequestsController::class, 'approve'])
            ->name('admin.leave.approve');

    Route::patch('/admin/dashboard/{id}/reject', [LeaveRequestsController::class, 'reject'])
            ->name('admin.leave.reject');

    Route::delete('/admin/dashboard/{id}', [LeaveRequestsController::class, 'destroy'])
            ->name('admin.leave.delete');

    Route::get('/admin/leave-requests/data', [LeaveRequestsController::class, 'getData'])
            ->name('admin.leave-requests.data');

    Route::middleware('can:manage users')
    ->group(function() {
        Route::get('/admin/users', [UserController::class, 'index'])
                ->name('admin.user.index');

        Route::get('admin/users/create', [UserController::class, 'create'])
                ->name('admin.user.create');

        Route::post('admin/users', [UserController::class, 'store'])
                ->name('admin.user.store');

        Route::get('admin/users/{id}/edit', [UserController::class, 'edit'])
                ->name('admin.user.edit');

        Route::patch('admin/users/{id}', [UserController::class, 'update'])
                ->name('admin.user.update');

        Route::delete('admin/users/{id}', [UserController::class, 'destroy'])
                ->name('admin.user.destroy');
    
    });
});