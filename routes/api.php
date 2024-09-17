<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\verificationCodeController;
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


Route::controller(UserController::class)->prefix('/Auth/')->group(function () {
    Route::post('Register', 'Register');
    Route::post('Login', 'Login');
    Route::post('Profile', 'Profile')->middleware('auth:sanctum');
    Route::post('Logout', 'Logout')->middleware('auth:sanctum');
    Route::post('change-password', 'changePassword')->middleware('auth:sanctum');
});

Route::controller(verificationCodeController::class)->prefix('/verification_code/')->group(function () {
    Route::post('Check_code', 'check_verification_code')->middleware('auth:sanctum');
    Route::post('Resend_code', 'Resend_verification_code')->middleware('auth:sanctum');
});
