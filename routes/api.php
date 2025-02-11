<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\AuthenticateDomainUser;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware(AuthenticateDomainUser::class);
    Route::middleware(AuthenticateDomainUser::class)->group(function () {
        Route::post('/generate-report', [ReportController::class, 'generateReport'])->name('generate-report');
        Route::get('/get-report/{reportId}', [ReportController::class, 'getReport'])
            ->name('get-report');
        Route::get('/list-reports', [ReportController::class, 'listReports'])->name('list-reports');
    });
});
