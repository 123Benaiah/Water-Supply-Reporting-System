<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController;
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
        Route::get('users', [AdminController::class, 'users'])->name('users');
    });

    Route::middleware('admin')->group(function () {
        Route::get('admin', function () {
            return redirect()->route('admin.dashboard');
        });
    });

    Route::get('dashboard', [ReportController::class, 'dashboard'])->name('dashboard');
    Route::get('reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('reports/{report}', [ReportController::class, 'show'])->name('reports.show');
});
