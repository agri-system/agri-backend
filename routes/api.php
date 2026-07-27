<?php

use App\Http\Controllers\Api\ActivationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [PasswordController::class, 'forgotPassword']);
    Route::post('reset-password', [PasswordController::class, 'resetPassword']);
    Route::get('activation/{token}', [ActivationController::class, 'check']);
    Route::post('activation/{token}', [ActivationController::class, 'activate']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('logout-all', [AuthController::class, 'logoutAll']);
        Route::get('me', [AuthController::class, 'me']);
        Route::get('user', [AuthController::class, 'refreshUser']);
    });
});

Route::prefix('profile')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ProfileController::class, 'show']);
    Route::put('/', [ProfileController::class, 'update']);
    Route::put('change-password', [PasswordController::class, 'changePassword']);
    Route::post('avatar', [ProfileController::class, 'updateAvatar']);
    Route::delete('avatar', [ProfileController::class, 'deleteAvatar']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('sessions', [SessionController::class, 'index']);
    Route::delete('sessions/{token}', [SessionController::class, 'destroy']);
    Route::delete('sessions', [SessionController::class, 'destroyAll']);

    Route::apiResource('roles', RoleController::class);
    Route::get('roles/{role}/permissions', [RoleController::class, 'permissions']);
    Route::put('roles/{role}/permissions', [RoleController::class, 'syncPermissions']);

    Route::get('permissions', [PermissionController::class, 'index']);
    Route::get('permissions/{permission}', [PermissionController::class, 'show']);

    Route::apiResource('users', UserController::class);
    Route::patch('users/{user}/restore', [UserController::class, 'restore'])->withTrashed();
    Route::patch('users/{user}/activate', [UserController::class, 'activate']);
    Route::patch('users/{user}/deactivate', [UserController::class, 'deactivate']);
    Route::put('users/{user}/roles', [UserController::class, 'updateRole']);
    Route::delete('users/{user}/roles/{role}', [UserController::class, 'removeRole']);
});
