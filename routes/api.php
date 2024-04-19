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

Route::get('/', function () {
    return response()->json(['message' => 'Gif API test'], 200);
})->name('api');

Route::get('unauthorized', function () {
    return response()->json(['message' => 'Unauthorized'], 401);
})->name('unauthorized');

Route::prefix('v1')->group(function () {

    Route::post('login', [App\Http\Controllers\api\AuthController::class, 'login'])->name('login');
    Route::post('register', [App\Http\Controllers\api\AuthController::class, 'register'])->name('register');

    Route::group(['middleware' => 'auth:api'], function () {

        Route::post('logout', [App\Http\Controllers\api\AuthController::class, 'logout'])->name('logout');

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [App\Http\Controllers\api\UserController::class, 'index'])->name('users.index');
            Route::get('/{id}', [App\Http\Controllers\api\UserController::class, 'show'])->name('users.show');
        });

        Route::group(['prefix' => 'gifs'], function () {
            Route::get('search', [App\Http\Controllers\api\GifController::class, 'search'])->name('gifs.search');
            Route::get('/{id}', [App\Http\Controllers\api\GifController::class, 'show'])->name('gifs.show');
            Route::post('/', [App\Http\Controllers\api\GifController::class, 'saveGifToFavorites'])->name('gifs.save');
        });

    });

});
