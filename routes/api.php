<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StatusController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [UserController::class, 'store']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::apiResource('tasks', TaskController::class);

    Route::patch('/tasks/{id}/mark-status', [TaskController::class, 'markStatus']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::prefix('statuses')->group(function () {
        Route::get('/', [StatusController::class, 'index']);
    });

});
