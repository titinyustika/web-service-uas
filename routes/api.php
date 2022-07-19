<?php

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
Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');

// bisa di akses dengan harus login dan membawa token yg di dapat di jwt saat login
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// bisa di akses dengan harus login dan membawa token yg di dapat di jwt saat login
Route::group(['middleware' => ['auth:api']], function () {

    // route berita
    Route::apiResource('/news', App\Http\Controllers\Api\BeritaController::class);
    Route::apiResource('/category', App\Http\Controllers\Api\CategoryController::class);
    Route::apiResource('/tag', App\Http\Controllers\Api\TagController::class);

    Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');
});




