<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DonorController;
use App\Http\Controllers\API\SupportController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(
    [
        'prefix' => 'auth',
        'as' => 'auth.',
    ],
    function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/set-admin/{userId}', [AuthController::class, 'setAdmin']);
        Route::post('/request-reset', [AuthController::class, 'requestReset'])->name('forgot password');
        Route::post('/reset-password', [AuthController::class, 'reset'])->name('reset password');
    }
);


Route::group(
    [
        'prefix' => 'user',
        'as' => 'user.',
        'middleware' => 'auth:sanctum'
    ],
    function () {
        Route::get('/profile', [UserController::class, 'me']);
        Route::put('/update/profile', [UserController::class, 'updateMe']);
        Route::get('/all', [UserController::class, 'all']);
        Route::get('/detail/{userId}', [UserController::class, 'detail']);
        Route::put('/update/{userId}', [UserController::class, 'update']);
        Route::delete('/delete/{userId}', [UserController::class, 'delete']);
    }
);

Route::group(
    [
        'prefix' => 'donor',
        'as' => 'donor.',
        'middleware' => 'auth:sanctum'
    ],
    function () {
        Route::get('/all', [DonorController::class, 'all']);
        Route::get('/me', [DonorController::class, 'myDonor']);
        Route::get('/all-request', [DonorController::class, 'allRequest']);
        Route::post('/confirmation/{donorId}', [DonorController::class, 'confirmation']);
        Route::post('/add-request', [DonorController::class, 'addRequest']);
        Route::get('/detail/{donorId}', [DonorController::class, 'detail']);
        // Route::put('/update/{donorId}', [DonorController::class, 'update']);
        Route::delete('/delete/{donorId}', [DonorController::class, 'delete']);
    }
);


Route::group(
    [
        'prefix' => 'support',
        'as' => 'support.',
        'middleware' => 'auth:sanctum'
    ],
    function () {
        Route::get('/all', [SupportController::class, 'all']);
        Route::get('/all-request', [SupportController::class, 'allRequest']);
        Route::get('/detail/{supportId}', [SupportController::class, 'detail']);
       
        Route::post('/add', [SupportController::class, 'add']);
        Route::post('/take/{supportId}', [SupportController::class, 'take']);
    }
);


