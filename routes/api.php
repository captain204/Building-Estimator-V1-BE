<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthenticationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogImageController;





Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
//Route::middleware('auth:sanctum')->post('logout', [AuthenticationController::class, 'logout']);
Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword']);
Route::get('/email/verify/{id}/{hash}', [AuthenticationController::class, 'verifyEmail'])
->middleware(['auth:sanctum', 'signed'])->name('verification.verify');
Route::get('/auth/google/redirect', [AuthenticationController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthenticationController::class, 'handleGoogleCallback']);
Route::post('/subscribe', [SubscriptionController::class, 'store']);
Route::get('/blog', [BlogController::class, 'index']);        
Route::get('/blog/{id}', [BlogController::class, 'show']);

Route::middleware('auth:sanctum')->prefix('users')->group(function () {
    
    // Profile routes
    Route::post('/profile', [ProfileController::class, 'create']);
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'delete']);

    
    // Authentication routes
    Route::post('/email/resend', [AuthenticationController::class, 'resendVerification']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('profile', [ProfileController::class, 'create']);
    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);
    Route::delete('profile', [ProfileController::class, 'delete']);
    // Authentication routes
    Route::post('/email/resend', [AuthenticationController::class, 'resendVerification']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);
});




Route::middleware(['auth:sanctum', AdminMiddleware::class])->prefix('admin')->group(function () {

     // Blog Routes
     Route::post('/blog', [BlogController::class, 'create']);               
     Route::put('/blog/{id}', [BlogController::class, 'update']);  
     Route::delete('/blog/{id}', [BlogController::class, 'destroy']);
     
     // Blog Images
     Route::post('/blog/images/{id}', [BlogImageController::class, 'store']);
     Route::put('/blog/images/{id}', [BlogImageController::class, 'update']);
     Route::delete('/blog/images/{id}', [BlogImageController::class, 'destroy']);
    
    

});





Route::get('/user', function (Request $request) {
    return response()->json($request->user());
})->middleware('auth:sanctum');


