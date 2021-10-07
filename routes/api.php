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

Route::post('demo1', 'DemoController@demo1');
Route::get('demo2', 'DemoController@demo2');
Route::get('demo3', 'DemoController@demo3');
Route::get('demo5', 'DemoController@demo5');
Route::get('demo6', 'DemoController@demo6');
Route::get('demo7', 'DemoController@demo7');
Route::get('demo8', 'DemoController@demo8');
Route::get('demo9', 'DemoController@demo9');

Route::get('class', 'ClassController@create');

Route::get('todo', 'TodoController@index');
