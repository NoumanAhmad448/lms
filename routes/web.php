<?php

use Eren\Lms\Controllers\AdminController;
use Eren\Lms\Controllers\DashboardController;
use Eren\Lms\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');
});

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/user_logout', [HomeController::class, 'logout'])->name('logout_user');
Route::post('/user_logout_post', [HomeController::class, 'logout'])->name('logout_post');
Route::get('/admin', [AdminController::class, 'admin_panel'])->name('admin');
Route::post('/admin/post', [AdminController::class, 'login'])->name('admin_a');

require __DIR__ . '/ins_profile.php';
require __DIR__ . '/course_mngmt.php';
require __DIR__ . '/admin.php';
