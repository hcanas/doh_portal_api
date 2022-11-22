<?php

use Illuminate\Support\Facades\Route;

Route::post('login', \App\Http\Controllers\Api\TokenController::class);

Route::apiResource('auth', \App\Http\Controllers\Api\AuthController::class)->only('store', 'destroy');

Route::post('change_password', \App\Http\Controllers\Api\ChangedPasswordController::class);

Route::apiResource('announcements', \App\Http\Controllers\Api\AnnouncementController::class);

Route::apiResource('users', \App\Http\Controllers\Api\UserController::class);

Route::apiResource('user/{id}/permissions', \App\Http\Controllers\Api\UserPermissionController::class);

Route::get('time_log', \App\Http\Controllers\Api\TimeLogController::class);

Route::get('id_cards/{user}', \App\Http\Controllers\Api\IDCardController::class);

Route::get('verify/{code}', \App\Http\Controllers\Api\VerifiedEmployeeController::class);

Route::apiResource('permissions', \App\Http\Controllers\Api\PermissionController::class);

Route::apiResource('offices', \App\Http\Controllers\Api\OfficeController::class);
