<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('reports/{report}', [AdminController::class, 'showReport'])->name('reports.show');
        Route::patch('reports/{report}', [AdminController::class, 'updateReport'])->name('reports.update');
        Route::delete('reports/{report}', [AdminController::class, 'destroyReport'])->name('reports.destroy');
        Route::delete('reports/{report}/image/{index}', [AdminController::class, 'deleteReportImage'])->name('reports.delete-image');
        Route::get('reports/status/{status}', [AdminController::class, 'reportsByStatus'])->name('reports.status');
    });

    Route::middleware('admin')->group(function () {
        Route::get('admin', function () {
            return redirect()->route('admin.dashboard');
        });
        
        Route::get('admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    });

    Route::get('dashboard', function () {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return app(ReportController::class)->dashboard(request());
    })->name('dashboard');
    Route::get('reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('reports/{report}', [ReportController::class, 'show'])->name('reports.show');

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('profile/update-profile', [ProfileController::class, 'updateProfile'])->name('profile.update-profile');
    Route::patch('profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::patch('profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.update-picture');
    Route::delete('profile/delete-picture', [ProfileController::class, 'deletePicture'])->name('profile.delete-picture');
});
