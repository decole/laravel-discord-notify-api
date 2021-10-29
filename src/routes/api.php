<?php

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

Route::get('notifications', 'App\Http\Controllers\DiscordNotificationController@index');
Route::get('notifications/{id}', 'App\Http\Controllers\DiscordNotificationController@show');
Route::post('notifications', 'App\Http\Controllers\DiscordNotificationController@store');
Route::put('notifications/{id}', 'App\Http\Controllers\DiscordNotificationController@update');
Route::delete('notifications/{id}', 'App\Http\Controllers\DiscordNotificationController@delete');
