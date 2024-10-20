<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthenticationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\SubscriptionController;



Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword']);
Route::get('/email/verify/{id}/{hash}', [AuthenticationController::class, 'verifyEmail'])
->middleware(['auth:sanctum', 'signed'])->name('verification.verify');
Route::get('/auth/google/redirect', [AuthenticationController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthenticationController::class, 'handleGoogleCallback']);
Route::post('/subscribe', [SubscriptionController::class, 'store']);



Route::get('/user', function (Request $request) {
    return $request->user();
    Route::post('/email/resend', [AuthenticationController::class, 'resendVerification']);
    Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');
})->middleware('auth:sanctum');
