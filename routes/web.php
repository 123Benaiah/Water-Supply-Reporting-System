<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('reports/{report}', [AdminController::class, 'showReport'])->name('reports.show');
        Route::put('reports/{report}', [AdminController::class, 'updateReport'])->name('reports.update');
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

    Route::get('dashboard', [ReportController::class, 'dashboard'])->name('dashboard');
    Route::get('reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('reports/{report}', [ReportController::class, 'show'])->name('reports.show');

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('profile/update-profile', [ProfileController::class, 'updateProfile'])->name('profile.update-profile');
    Route::post('profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.update-picture');
    Route::delete('profile/delete-picture', [ProfileController::class, 'deletePicture'])->name('profile.delete-picture');
});
