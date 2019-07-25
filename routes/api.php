<?php

use Illuminate\Http\Request;

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

Route::prefix('tecdoc')->group(function () {
    Route::post('get-models', 'Api\TecdocController@getModels')->name('api.tecdoc.get-models');
    Route::post('get-modifications', 'Api\TecdocController@getModifications')->name('api.tecdoc.get-modifications');
});
