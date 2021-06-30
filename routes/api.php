<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;

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

Route::post('/order/create/{shippingCost}', [OrdersController::class, 'createOrder']);
Route::post('/order/check-country/{countryCode}', [OrdersController::class, 'checkCountry']);
Route::post('/order/cancel/{orderId}', [OrdersController::class, 'cancel']);
Route::post('/order/details/{orderId}', [OrdersController::class, 'details']);
Route::post('/order/capture/', [OrdersController::class, 'capture']);