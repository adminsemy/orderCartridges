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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */
Route::namespace('Api')->group(function() {
    Route::get('users', 'UserController@index');
    Route::get('users/{user}', 'UserController@show');
    Route::put('/users/{user}', 'UserController@update');
    Route::get('/printer_brands', 'PrintersController@brands');
    Route::get('printers', 'PrintersController@index');
    Route::get('/printer/{printer}/order', 'PrintersController@show');
    Route::put('/printer/{printer_id}/order', 'OrderController@create');
    Route::get('/admin/order', 'OrderController@index');
    Route::post('/admin/send/cartridge/order/{historyOrder}', 'OrderController@sendCartridge');
    Route::delete('/admin/delete/order/{id}', 'OrderController@delete');
});
