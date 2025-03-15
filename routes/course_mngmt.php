<?php

use Eren\Lms\Controllers\CourseEx3Controller;
use Eren\Lms\Controllers\DashboardController;
use Eren\Lms\Controllers\PricingController;
use Eren\Lms\Controllers\PromotionController;
use Eren\Lms\Controllers\SayonaraController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {

    Route::get('instructor/course/{course_id}/manage/curriculum', [DashboardController::class, 'course_curriculum'])
        ->name('courses_curriculum');


    Route::get('instructor/course/{course}/pricing', [PricingController::class, 'pricing'])
        ->name('pricing');

    Route::post('instructor/course/{course}/pricing', [PricingController::class, 'savePricing'])
        ->name('pricingPost');


    Route::get('instructor/course/{course}/promotion', [PromotionController::class, 'promotion'])
        ->name('promotion');

    Route::post('instructor/course/{course}/coupon', [PromotionController::class, 'saveCoupon'])
        ->name('saveCoupon');

    Route::post('instructor/coupon/{promotion}/update_coupon', [PromotionController::class, 'updateCoupon'])
        ->name('updateCoupon');

    Route::delete('instructor/coupon/{promotion}/delete_coupon', [PromotionController::class, 'deleteCoupon'])
        ->name('delete_coupon');

    Route::get('instructor/course/{course}/final_message', [SayonaraController::class, 'sayonara'])
        ->name('zaijian');

    Route::post('instructor/course/{course}/final_message', [SayonaraController::class, 'storeSayonara'])
        ->name('zaijianPost');

    Route::post('instructor/course/{course}/submit-course', [SayonaraController::class, 'submitCourse'])
        ->name('submitCourse');

});
