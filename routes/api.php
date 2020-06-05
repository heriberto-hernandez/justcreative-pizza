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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
	'pizza' => 'API\PizzaController',
	'order' => 'API\OrderController',
	'size' => 'API\SizeController',
]);
Route::get('by-size/{id}',	'API\PizzaController@bySize');
Route::get('order-details/{id}',	'API\OrderController@orderDetails');
Route::get('remove-pizza-order/{order}/{pizza}/{created}',	'API\OrderController@removePizzaOrder');
Route::post('add-pizza-order',	'API\OrderController@addPizzaOrder');