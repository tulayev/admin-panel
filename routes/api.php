<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\AuthController;


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('user', [UserController::class, 'user']);
    Route::put('users/info', [UserController::class, 'updateInfo']);
    Route::put('users/password', [UserController::class, 'updatePassword']);
    Route::post('upload', [ImageController::class, 'upload']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class)->only('index', 'show');
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

