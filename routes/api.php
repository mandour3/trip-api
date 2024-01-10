<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\AddTripController;
use App\Http\Controllers\Dashboard\ShowNotificationController;
use App\Http\Controllers\Dashboard\UpdateProfileController;
use App\Http\Controllers\PageInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);


Route::get('/page-info', [PageInfoController::class, 'getPageInfo']);

Route::middleware('auth:sanctum')->group(function () {

    //Trip
    Route::post('/add-trip', [AddTripController::class, 'add']);
    Route::post('/show-trips', [AddTripController::class, 'show']);
    Route::post('/show-trips-single/{id}', [AddTripController::class, 'show_single']);
    //update
    Route::post('/update-profile/{id}', [UpdateProfileController::class, 'update_profile']);
    Route::post('/updatePassword/{id}', [UpdateProfileController::class, 'updatePassword']);
    //notification
    Route::post('/ShowNotification', [ShowNotificationController::class, 'show']);








});

