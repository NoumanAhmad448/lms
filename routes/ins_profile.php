<?php

use Eren\Lms\Controllers\CourseExController;
use Eren\Lms\Controllers\DashboardController;
use Eren\Lms\Controllers\InstructorPaymentController;
use Eren\Lms\Controllers\LandingPageController;
use Eren\Lms\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Eren\Lms\Controllers\ProfileController;

Route::middleware(['web', 'auth'])->group(function () {

    Route::get('Instructor/instructor-profile', [ProfileController::class, 'getProfile'])->name('i-profile');
    Route::post('instructor-profile', [ProfileController::class, 'saveProfile'])->name('i-profile-post');
    Route::get('instructor/instructor-payment', [InstructorPaymentController::class, 'paymentGateways'])->name('i-payment-setting');
    Route::get('instructor/purchase-history', [PaymentController::class, 'purHis'])->name('purHis');
    Route::get('instructor/course/{course}/course-landing', [LandingPageController::class, 'landing_page'])
        ->name('landing_page');

    Route::get('laoshi-de/comments/{course}', [CourseExController::class, 'readComments'])->name('laoshi_de_c');

    Route::post('instructor/course/{course}/course-landing', [LandingPageController::class, 'store_landing_page'])
        ->name('landing_page_post');

    Route::get('/course/{course_id}/manage/goals', [DashboardController::class, 'show'])
        ->name('courses_dashboard');

    Route::post('/course/{course_id}/manage/goals', [DashboardController::class, 'save_record'])
        ->name('courses_dashboard_post');
    Route::get('instructor/comments/course/{course_name}', [CourseExController::class, 'comment'])->name('laoshi-comment');
    Route::post('instructor/comments', [CourseExController::class, 'commentPost'])->name('laoshi-commentPost');
    Route::patch('instructor/comments/update', [CourseExController::class, 'commentUpdate'])->name('laoshi-commentUpdate');
    Route::post('instructor/comments/delete', [CourseExController::class, 'commentDelete'])->name('laoshi-commentDelete');
});
