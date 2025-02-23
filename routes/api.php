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
use App\Http\Controllers\LabourRatesController;
use App\Http\Controllers\CallRequestController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CostTrackerController;
use App\Http\Controllers\EstimatorController;
use App\Http\Controllers\TradesmenVendorController;







Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
//Route::middleware('auth:sanctum')->post('logout', [AuthenticationController::class, 'logout']);
Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword']);
Route::get('/email/verify/{id}/{hash}', [AuthenticationController::class, 'verifyEmail'])
->middleware(['auth:sanctum', 'signed'])->name('verification.verify');
Route::get('/auth/google/redirect', [AuthenticationController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthenticationController::class, 'handleGoogleCallback']);
Route::post('/subscribe', [SubscriptionController::class, 'store']);
Route::post('/unsubscribe', [SubscriptionController::class, 'unsubscribe']);
Route::post('/callback-requests', [CallRequestController::class, 'store']); 
Route::get('/blog', [BlogController::class, 'index']);        
Route::get('/blog/{id}', [BlogController::class, 'show']);
Route::get('/events', [EventController::class, 'index']); 
Route::get('/events/{id}', [EventController::class, 'show']);
Route::get('cost-trackers', [CostTrackerController::class, 'index']);
Route::get('cost-trackers/{id}', [CostTrackerController::class, 'show']);
Route::get('tradesmen-vendors', [TradesmenVendorController::class, 'index']); 
Route::post('tradesmen-vendors', [TradesmenVendorController::class, 'store']); 
Route::get('tradesmen-vendors/{id}', [TradesmenVendorController::class, 'show']); 




Route::middleware('auth:sanctum')->prefix('users')->group(function () {
    
    // Profile routes
    Route::post('/profile', [ProfileController::class, 'create']);
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'delete']);



    
    // Authentication routes
    Route::post('/email/resend', [AuthenticationController::class, 'resendVerification']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    #Estimates
    Route::post('/estimator', [EstimatorController::class, 'store']);

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
     #Route::apiResource('material-price-lists', MaterialPriceListController::class);
     Route::get('material-price-lists', [MaterialPriceListController::class, 'index'])->name('material-price-lists.index');
     Route::get('material-price-lists/{id}', [MaterialPriceListController::class, 'show'])->name('material-price-lists.show');
     Route::post('material-price-lists', [MaterialPriceListController::class, 'store'])->name('material-price-lists.store');
     Route::put('material-price-lists/{id}', [MaterialPriceListController::class, 'update'])->name('material-price-lists.update');
     Route::patch('material-price-lists/{id}', [MaterialPriceListController::class, 'update'])->name('material-price-lists.update');
     Route::delete('material-price-lists/{id}', [MaterialPriceListController::class, 'destroy'])->name('material-price-lists.destroy');

     #Labor Rates
     #Route::apiResource('labor-price-lists', LabourRatesController::class);
     Route::get('labor-price-lists', [LabourRatesController::class, 'index'])->name('labor-price-lists.index');
     Route::get('labor-price-lists/{id}', [LabourRatesController::class, 'show'])->name('labor-price-lists.show');
     Route::post('labor-price-lists', [LabourRatesController::class, 'store'])->name('labor-price-lists.store');
     Route::put('labor-price-lists/{id}', [LabourRatesController::class, 'update'])->name('labor-price-lists.update');
     Route::patch('labor-price-lists/{id}', [LabourRatesController::class, 'update'])->name('labor-price-lists.update');
     Route::delete('labor-price-lists/{id}', [LabourRatesController::class, 'destroy'])->name('labor-price-lists.destroy');

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
     #Send Newsletter
     Route::post('/newsletter/send', [SubscriptionController::class, 'sendNewsletter']);
     Route::get('/subscribe/total', [SubscriptionController::class, 'totalSubscribers']);
     Route::get('/unsubscribed/total', [SubscriptionController::class, 'totalUnsubscribed']);
     Route::get('/subscribers', [SubscriptionController::class, 'getAllSubscribers']);

    
    #Call Back Request
    Route::get('/callback-requests', [CallRequestController::class, 'index']); 
    Route::patch('/callback-requests/{id}/response', [CallRequestController::class, 'updateResponse']); 
    Route::delete('/callback-requests/{id}', [CallRequestController::class, 'destroy']);
    Route::get('callback-requests/total-responses', [CallRequestController::class, 'totalResponses']);

    #Event
    Route::post('/events', [EventController::class, 'store']);  
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
    
    #Cost tracker
    Route::get('cost-trackers', [CostTrackerController::class, 'index']);
    Route::post('cost-trackers', [CostTrackerController::class, 'store']);
    Route::get('cost-trackers/{id}', [CostTrackerController::class, 'show']);
    Route::put('cost-trackers/{id}', [CostTrackerController::class, 'update']);
    Route::delete('cost-trackers/{id}', [CostTrackerController::class, 'destroy']);

    #Estimators
    Route::get('/estimate/all', [EstimatorController::class, 'getAllEstimates']);
    Route::get('/estimate/automated', [EstimatorController::class, 'getAutomatedEstimates']);
    Route::get('/estimate/custom', [EstimatorController::class, 'getCustomEstimates']);
    Route::get('/estimate/{id}', [EstimatorController::class, 'getEstimateById']);

    #Tradesmen Vendor Controller
    Route::put('tradesmen-vendors/{id}', [TradesmenVendorController::class, 'update']); 
    Route::delete('tradesmen-vendors/{id}', [TradesmenVendorController::class, 'destroy']); 


});



Route::get('/user', function (Request $request) {
    return response()->json($request->user());
})->middleware('auth:sanctum');












































































































































































