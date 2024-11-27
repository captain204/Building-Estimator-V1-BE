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
use App\Http\Controllers\EstimateCategoryController;
use App\Http\Controllers\EstimateCategoryOptionController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\SubOptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaterialPriceListController;





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
    
     #Estimates Category
     Route::get('/categories', [EstimateCategoryController::class, 'index']);
     Route::get('/categories/{id}', [EstimateCategoryController::class, 'show']);     
     Route::post('/categories', [EstimateCategoryController::class, 'store']);
     Route::put('/categories/{id}', [EstimateCategoryController::class, 'update']);
     Route::delete('/categories/{id}', [EstimateCategoryController::class, 'destroy']);
    
     #Automated Question Routes
     Route::apiResource('questions', QuestionController::class);
     #Route::apiResource('options', OptionController::class);
     #Route::apiResource('suboptions', SubOptionController::class);
     #Options
     Route::get('options', [OptionController::class, 'index'])->name('options.index');
     Route::get('options/{option}', [OptionController::class, 'show'])->name('options.show');
     Route::post('options', [OptionController::class, 'store'])->name('options.store');
     Route::put('options/{option}', [OptionController::class, 'update'])->name('options.update');
     Route::patch('options/{option}', [OptionController::class, 'update'])->name('options.update');
     Route::delete('options/{option}', [OptionController::class, 'destroy'])->name('options.destroy');
     #SubOptions
     Route::get('suboptions', [SubOptionController::class, 'index'])->name('suboptions.index');
     Route::get('suboptions/{suboption}', [SubOptionController::class, 'show'])->name('suboptions.show');
     Route::post('suboptions', [SubOptionController::class, 'store'])->name('suboptions.store');
     Route::put('suboptions/{suboption}', [SubOptionController::class, 'update'])->name('suboptions.update');
     Route::patch('suboptions/{suboption}', [SubOptionController::class, 'update'])->name('suboptions.update');
     Route::delete('suboptions/{suboption}', [SubOptionController::class, 'destroy'])->name('suboptions.destroy');

     #Material PriceList
     Route::apiResource('material-price-lists', MaterialPriceListController::class);


     #User Admin Controller
     Route::post('/create', [UserController::class, 'createAdmin']);
     Route::put('/update/{id}', [UserController::class, 'updateAdmin']);
     Route::get('/all', [UserController::class, 'getAllAdmins']);
     Route::delete('/deleteadmin/{id}', [UserController::class, 'deleteAdmin']);
     Route::get('/verified-users', [UserController::class, 'getVerifiedUsers']);
     Route::get('/unverified', [UserController::class, 'getUnverifiedUsers']);
     Route::get('/users', [UserController::class, 'getAllUsers']);
     Route::put('ban/{id}', [UserController::class, 'banUser']);
     Route::patch('/{id}/unban', [UserController::class, 'unbanUser']);
     Route::get('/banned-users', [UserController::class, 'getBannedUsers']);
     Route::get('users/count', [UserController::class, 'countAllUsers']);
     Route::get('/verified-users/count', [UserController::class, 'countVerifiedUsers']);
     Route::get('/unverified-users/count', [UserController::class, 'countUnverifiedUsers']);
     Route::get('/banned-users/count', [UserController::class, 'countBannedUsers']);
});





Route::get('/user', function (Request $request) {
    return response()->json($request->user());
})->middleware('auth:sanctum');


