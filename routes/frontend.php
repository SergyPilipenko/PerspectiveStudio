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
//
Route::prefix('{modificationId}/categories')->group(function (){
    Route::get('/', 'Frontend\CategoriesController@index')->name('frontend.categories.index');
//    Route::get('{category}/{children}', 'Frontend\CategoriesController@show')->name('frontend.categories.show');
    Route::get('{categories}', 'Frontend\CategoriesController@show')
        ->where('categories','^[a-zA-Z0-9-_\/]+$')->name('frontend.categories.show');
});


$brand = '{brand}';
$model = '{model}';
$categories = '{categories}';
$part = '{part}';
$modification = '{modification}';


Route::get(implode('-', [$brand, $model]).'-c-'.$categories, 'Frontend\CategoriesController@show')
    ->where('categories','^[a-zA-Z0-9-_\/]+$')->name('frontend.categories.show');
Route::get(implode('-', [$brand, $model, $modification]), 'Frontend\PagesController@modification')->name('auto.model.modification');
Route::get(implode('-', [$brand, $model]), 'Frontend\CategoriesController@index');
Route::get(implode('-', [$brand, $model]), 'Frontend\PagesController@model')->name('auto.model');
Route::get($brand, 'Frontend\PagesController@brand');
Route::get('change-current-car/{id}', 'Frontend\PagesController@changeCurrentCar')->name('garage-change-current-car');
Route::get('garage-remove-car/{id}', 'Frontend\PagesController@removeCar')->name('garage-change-current-car');

Route::post('set-car-year', function (Illuminate\Http\Request $request, \App\Classes\Garage $garage) {
    $garage->setCurrentYear($request->selected_year);
})->name('set-car-year');

