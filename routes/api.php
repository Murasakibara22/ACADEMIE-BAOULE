<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\Auth\AuthController;



Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('login/phone', [AuthController::class, 'loginByPhone']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('jwt.verify');
    Route::post('me', [AuthController::class, 'me'])->middleware('jwt.verify');
    Route::post('register', [AuthController::class, 'register']);
    Route::post('social', [AuthController::class, 'RegisterOrLoginBySociale']);
    Route::post('verify_customer', [AuthController::class, 'verifyCustomer']);
});

    Route::get('slides', [SlideController::class, 'index']);

Route::group(['middleware' => 'jwt.verify'], function () {


});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

