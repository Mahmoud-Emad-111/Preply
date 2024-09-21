<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherFollwersController;
use App\Http\Controllers\verificationCodeController;
use App\Http\Controllers\WorkingHoursController;
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
    Route::post('Teacher-Following', 'Teacher_Following')->middleware('auth:sanctum');
});


Route::controller(TeacherController::class)->prefix('/Teacher/')->group(function () {
    Route::post('Register', 'Register');
    Route::post('Login', 'Login');
    Route::post('Profile', 'Profile')->middleware('auth:sanctum');
    Route::post('Logout', 'Logout')->middleware('auth:sanctum');
    Route::post('change-password', 'changePassword')->middleware('auth:sanctum');

});

Route::controller(verificationCodeController::class)->prefix('/verification_code/')->group(function () {
    Route::post('check-code-user', 'check_verification_code_User');
    Route::post('resend-code-user', 'Resend_verification_code_user');
    Route::post('check-code-teacher', 'check_code_Teacher');
    Route::post('resend-code-teacher', 'Resend_code_Teacher');
});


Route::controller(WorkingHoursController::class)->prefix('/WorkingHours/')->group(function () {
    Route::post('Store', 'Store')->middleware('auth:sanctum');
    Route::get('Get', 'Get')->middleware('auth:sanctum');
    Route::Post('Update', 'Update')->middleware('auth:sanctum');
});

Route::controller(TeacherFollwersController::class)->prefix('/Follow/')->group(function () {
    Route::post('Store', 'Store')->middleware('auth:sanctum');
    Route::post('Unfollow', 'Unfollow')->middleware('auth:sanctum');
    Route::get('Teacher-Following', 'Teacher_Following')->middleware('auth:sanctum');
    Route::get('Teacher-Followers', 'Teacher_Followers')->middleware('auth:sanctum');

});
