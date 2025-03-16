<?php

use Eren\Lms\Controllers\AdminController;
use Eren\Lms\Controllers\CategoriesController;
use Eren\Lms\Controllers\CourseEx3Controller;
use Eren\Lms\Controllers\DashboardController;
use Eren\Lms\Controllers\HomeController;
use Eren\Lms\Controllers\InstructorAuthController;
use Eren\Lms\Controllers\SocialController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');
});

Route::middleware(['web'])->group(function () {
    Route::get('show-all-courses', [CourseEx3Controller::class, 'showAllCourses'])->name('show-all-courses');

    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/user_logout', [HomeController::class, 'logout'])->name('logout_user');
    Route::post('/user_logout_post', [HomeController::class, 'logout'])->name('logout_post');
    Route::get('/admin', [AdminController::class, 'admin_panel'])->name('admin');
    Route::post('/admin/post', [AdminController::class, 'login'])->name('admin_a');
    Route::get('course/{slug}', [CourseEx3Controller::class, 'showCourse'])->name('user-course');

    // social login
    Route::get('/login/google', [SocialController::class, 'googleVerification'])->name('google-login');
    Route::get('/google/callback', [SocialController::class, 'googleLogin']);

    Route::get('/login/facebook', [SocialController::class, 'facebookVerification'])->name('fb-login');
    Route::get('/facebook/callback', [SocialController::class, 'facebookLogin'])->route('facebook.callback');

    Route::get('/login/linkedin', [SocialController::class, 'linkedinVerification'])->name('li-login');
    Route::get('/linkedin/callback', [SocialController::class, 'linkedinLogin']);

    Route::post('course-search', [HomeController::class, 'userSearch'])->name('c-search-page');
    Route::get('show-search-course/{keyword}', [HomeController::class, 'showSearchCourse'])->name('s-search-page');

    Route::get('/instructor/register', [InstructorAuthController::class, 'showRegister'])
        ->name('instructor.register');
    Route::post('/instructor/register', [InstructorAuthController::class, 'register']);

    Route::get('/instructor/login', [InstructorAuthController::class, 'showLogin'])
        ->name('instructor.login');
    Route::post('/instructor/login', [InstructorAuthController::class, 'login'])->name("instructor.login.post");
    Route::get('categories/{category}', [CategoriesController::class, 'showCategory'])->name('user-categories');
});

require __DIR__ . '/ins_profile.php';
require __DIR__ . '/course_mngmt.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/dashboard.php';
require __DIR__ . '/student.php';
require __DIR__ . '/guest.php';
