<?php

use Illuminate\Http\Request;

/*php
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

//PERU
Route::get('departments', 'API\PeruController@departments');
Route::get('provinces/{id}', 'API\PeruController@provinces');
Route::get('districts/{id}', 'API\PeruController@districts');
Route::post('sunat', 'API\ClientsController@sunat');
Route::post('clientRuc', 'API\ClientsController@ruc');
Route::post('clientName', 'API\ClientsController@name');
Route::post('good', 'API\GoodsController@search');

//USUARIOS
Route::apiResources(['client' => 'API\ClientsController']);
