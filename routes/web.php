<?php

use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('products', ProductController::class);

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/remove/{product}', [CartController::class, 'removeFromCart'])->name('cart.remove');
});
