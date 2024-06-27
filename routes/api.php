<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
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


Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/create', [ProductController::class, 'store']);
    Route::get('/show/{product}', [ProductController::class, 'show']);
    Route::put('/update/{product}', [ProductController::class, 'update']);
    Route::delete('/destroy/{product}', [ProductController::class, 'destroy']);
});

Route::prefix('cart')->group(function () {
    Route::post('/add-to-cart', [CartController::class, 'addToCart']);
    Route::delete('/remove-from-cart/{product}', [CartController::class, 'removeFromCart']);
    Route::get('/view-cart', [CartController::class, 'viewCart']);
});
