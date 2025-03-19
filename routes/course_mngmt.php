<?php

use Eren\Lms\Controllers\CourseController;
use Eren\Lms\Controllers\CourseEx3Controller;
use Eren\Lms\Controllers\CourseExController;
use Eren\Lms\Controllers\DashboardController;
use Eren\Lms\Controllers\LandingPageController;
use Eren\Lms\Controllers\PricingController;
use Eren\Lms\Controllers\PromotionController;
use Eren\Lms\Controllers\SayonaraController;
use Eren\Lms\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', "lms-web"])->group(function () {
    Route::post('instructor/course/{course}/upload-bulk-loader', [VideoController::class, 'uploadBulkLoader'])
        ->name('bulk_loader');


    Route::post('instructor/course/{course_id}/manage/section_title', [DashboardController::class, 'course_curriculum_post'])
        ->name('courses_curriculum_post');

    Route::get('instructor/course/{course_id}/manage/curriculum', [DashboardController::class, 'course_curriculum'])
        ->name('courses_curriculum');

    Route::post('set-all-videos-downlabable/{course}', [CourseExController::class, 'setVidDown'])->name('setVidDown');

    Route::post('update-lecture-status/{media_id}', [VideoController::class, 'set_video_free'])->name('update-lecture-status');

    Route::post('e/{course_id}/{media_id}/edit_video', [VideoController::class, 'edit_video'])->name('e_video');

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

    Route::post('/create_course', [CourseController::class, 'createCourse'])
        ->name('create_course');

    Route::get('courses/public-announcement', [CourseEx3Controller::class, 'publicAnn'])->name('public-ann');

    Route::post('courses/public-announcement', [CourseEx3Controller::class, 'publicAnnPost'])->name('public-ann-post');


    Route::post('instructor/course/{course}/course-image', [LandingPageController::class, 'course_img'])
        ->name('course_img');

    Route::post('instructor/course/{course}/course-video', [LandingPageController::class, 'course_vid'])
        ->name('course_vid');


    Route::get('instructor/course/{course}/setting-course-status', [CourseEx3Controller::class, 'setting'])
        ->name('setting');

    Route::post('instructor/course/{course}/setting-course-status', [CourseEx3Controller::class, 'PostSetting'])
        ->name('post_setting');

    Route::post('instructor/course/{course}/setting-delete-course', [CourseEx3Controller::class, 'delCourseSetting'])
        ->name('del-course_setting');
});
