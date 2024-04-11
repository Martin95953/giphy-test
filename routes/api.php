<?php

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

Route::get('unauthorized', function () {
    return response()->json(['message' => 'Unauthorized'], 401);
})->name('unauthorized');

Route::prefix('v1')->group(function () {

    Route::post('login', [App\Http\Controllers\api\AuthController::class, 'login'])->name('login');
    Route::post('register', [App\Http\Controllers\api\AuthController::class, 'register'])->name('register');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', [App\Http\Controllers\api\AuthController::class, 'logout'])->name('logout');
        Route::get('user', function (Request $request) {
            return "test";
        });
    });

});
