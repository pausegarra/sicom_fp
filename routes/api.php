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

/*Route::any('/create', 'Auth\RegisterController@create2');
Route::any('tipsa/print','TipsaController@print')->middleware('auth:api');
Route::any('tipsa/delete/{id}','TipsaController@destroy')->middleware('auth:api');
Route::any('tipsa/store','TipsaController@store')->middleware('auth:api');
Route::any('tipsa/show/{id}','TipsaController@show')->middleware('auth:api');
Route::any('tipsa/printall','TipsaController@printall')->middleware('auth:api');
Route::any('tipsa','TipsaController@index')->middleware('auth:api');
Route::any('tipsa2',
function()
{
    return 'Hello World';
}

)->middleware('auth:api');
Route::any('login',
function()
{
    return 'LOG ME IN PLEASE';
}

);*/
