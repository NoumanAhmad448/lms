<?php

use Illuminate\Support\Facades\Route;
use Eren\Lms\Controllers\AdminController;
use Eren\Lms\Controllers\CourseController;

Route::prefix("admin")->middleware(['web','admin'])->group(function () {

    Route::get('/get-draft-courses', [AdminController::class, 'draftCourse'])->name('draft_course');
    Route::get('/get-published-courses', [AdminController::class, 'publishedCourse'])->name('p_courses');
    Route::get('/courses/new-courses', [CourseController::class, 'newCourse'])->name('i_new_courses');
});
