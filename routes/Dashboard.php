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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::controller(UserController::class)->prefix('/user/')->group(function () {
    Route::post('ChangeStatus', 'ChangeStatus');
    Route::get('Get', 'Get');

});


