<?php

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


//Route::get('parts/{modificationId}', 'Frontend\PartsController@index');

Route::prefix('{modificationId}/categories')->group(function (){
    Route::get('/', 'Frontend\CategoriesController@index')->name('frontend.categories.index');
//    Route::get('{category}/{children}', 'Frontend\CategoriesController@show')->name('frontend.categories.show');
    Route::get('{categories}', 'Frontend\CategoriesController@show')
        ->where('categories','^[a-zA-Z0-9-_\/]+$')->name('frontend.categories.show');
});

//Route::get('{modificationId}/categories/', 'Frontend\CategoriesController@index')->name('frontend.categories.index');
