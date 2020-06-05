<?php

use App\Entities\Order;
use App\Entities\Pizza;
use App\Entities\OrderPizza;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\Pizza as PizzaResources;
use App\Http\Resources\OrderPizza as OrderPizzaResources;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'HomeController@index');
Auth::routes(['register' => false]);
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/create-order', 'HomeController@createOrder')->name('create.order');
Route::get('/order-details/{number_order}', 'HomeController@orderDetails')->name('order.details');
Route::get('/order-list', 'HomeController@orderList')->name('order.list')->middleware('isadmin');