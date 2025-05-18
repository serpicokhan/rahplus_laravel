<?php

use Illuminate\Support\Facades\Route;



Route::name('user.')->group(function () {
    Route::middleware(['auth', 'check.status', 'registration.complete'])
        ->prefix('deposit')
        ->name('deposit.')
        ->controller('Gateway\PaymentController')
        ->group(function () {
            Route::get('confirm', 'depositConfirm')->name('confirm');
            Route::any('history', 'depositHistory')->name('history');
            Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
            Route::post('manual', 'manualDepositUpdate')->name('manual.update');
        });
});
