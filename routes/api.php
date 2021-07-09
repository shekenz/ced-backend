<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CartController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

//TODO secure the api

// Live cart
Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.api.add');
Route::post('/cart/remove/{book}', [CartController::class, 'remove'])->name('cart.api.remove');
Route::post('/cart/check/', [CartController::class, 'updateCart'])->name('cart.api.check');

// Order (Paypal)
Route::post('/order/create/{shippingMethod}', [OrdersController::class, 'createOrder']);
Route::post('/order/check-country/{countryCode}', [OrdersController::class, 'checkCountry']);
Route::post('/order/cancel/{order}', [OrdersController::class, 'cancel']);
Route::post('/order/details/{orderID}', [OrdersController::class, 'details']);
Route::post('/order/capture/{orderID}', [OrdersController::class, 'capture']);
Route::post('/orders/unread/count', [OrdersController::class, 'countUnread']);