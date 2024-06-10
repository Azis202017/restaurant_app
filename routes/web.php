<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\web\ReportController;
use App\Http\Controllers\web\ResepController;

Route::get('/',[AuthController::class,'index']);
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::middleware(['auth.dashboard'])->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/resep', [ResepController::class,'index'])->name('resep');
    Route::get('/report', [ReportController::class,'index'])->name('report');
    Route::post('/report/edit/{id}', [ReportController::class,'editStatus'])->name('report.edit');
    Route::post('/update-status/{id}',[ ResepController::class,'updateStatus'])->name('update_status');


});
