<?php

use Eren\Lms\Controllers\CourseController;
use Eren\Lms\Controllers\CourseEx3Controller;
use Eren\Lms\Controllers\CourseExController;
use Eren\Lms\Controllers\DashboardController;
use Eren\Lms\Controllers\InstructorPaymentController;
use Eren\Lms\Controllers\LandingPageController;
use Eren\Lms\Controllers\PricingController;
use Eren\Lms\Controllers\PromotionController;
use Eren\Lms\Controllers\SayonaraController;
use Eren\Lms\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', "lms-web"])->group(function () {

    Route::post('instructor/bank-detail', [InstructorPaymentController::class, 'storeBankPayment'])->name('i_bank_payment');
    Route::post('instructor/paypal-detail', [InstructorPaymentController::class, 'storePaypalPayment'])->name('i_paypal_payment_withdraw');
    Route::post('instructor/payoneer-detail', [InstructorPaymentController::class, 'storePayoneerPayment'])->name('i_payoneer_payment_withdraw');
    Route::post('instructor/jazzcash-detail', [InstructorPaymentController::class, 'storeJazzcashPayment'])->name('i_jazzcash_payment_withdraw');
    Route::post('instructor/easypaisa-detail', [InstructorPaymentController::class, 'storeEasypaisaPayment'])->name('i_easypaisa_payment_withdraw');
});
