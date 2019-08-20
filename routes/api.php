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
    Route::post('get-brands', 'Api\TecdocController@getBrands')->name('api.tecdoc.get-brands');
    Route::post('get-models', 'Api\TecdocController@getModels')->name('api.tecdoc.get-models');
    Route::post('get-modifications', 'Api\TecdocController@getModifications')->name('api.tecdoc.get-modifications');
    Route::post('get-models-body-types', 'Api\TecdocController@getModelsBodyTypes')->name('api.tecdoc.get-models-body-types');
    Route::post('get-models-engines', 'Api\TecdocController@getModelsEngines')->name('api.tecdoc.get-models-engines');
    Route::post('get-filtered-modifications', 'Api\TecdocController@getFilteredModifications')->name('api.tecdoc.get-filtered-modifications');
    Route::post('get-brands-by-models-created-year', 'Api\TecdocController@getBrandsByModelsCreatedYear')->name('api.get-brands-by-models-created-year');
});

