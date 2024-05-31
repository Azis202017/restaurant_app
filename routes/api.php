<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ResepController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/tips', [TipsController::class, 'index']);
    Route::post('/tips/add-tips', [TipsController::class, 'create']);
    Route::get('notifikasi', [NotifikasiController::class,'index']);
    Route::post('notifikasi/create',[NotifikasiController::class,'create']);

    Route::get('resep', [ResepController::class,'index']);
    Route::post('resep/create',[ResepController::class,'create']);
    Route::patch('resep/status/{id}',[ResepController::class,'changeStatus']);
    Route::get('resep/find-my-recept',[ResepController::class,'findMyResept']);
    Route::post('resep/edit/{id}',[ResepController::class,'update']);

    




});
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
