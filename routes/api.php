<?php

use App\Http\Controllers\API\AuthController;
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
