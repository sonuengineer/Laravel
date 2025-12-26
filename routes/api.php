<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/projects',[ProjectController::class,'index']);
     Route::get('/users', [UserController::class, 'index']);
    Route::post('/projects',[ProjectController::class,'store']);

    Route::get('/tasks',[TaskController::class,'index']);
    Route::post('/tasks',[TaskController::class,'store']);
    Route::patch('/tasks/{task}/status',[TaskController::class,'updateStatus']);
    Route::patch('/tasks/{task}/due-date', [TaskController::class, 'updateDueDate']);
});
