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

if(!Cache::get('brands')) {
    Cache::rememberForever('brands', function () {
        return \App\Models\ManufacturersUri::get()->pluck('slug')->toArray();
    });
}

foreach (Cache::get('brands') as $key => $brand) {


    if(!Cache::get('brands.' . $brand . 'models_uri')) {
        $models_uri = \App\Models\ManufacturersUri::where('slug', $brand)->first()->models_uri()->get()->pluck('slug')->toArray();
        Cache::forever('brands.' . $brand . 'models_uri', $models_uri);
    };


    foreach (Cache::get('brands.' . $brand . 'models_uri') as $item) {
        if(preg_match('/-/', $item)) {
            Route::get($brand . "-$item", 'Frontend\PagesController@model')->name('auto.' . $brand . '.model');
            Route::get($brand . "-$item-{modification}", 'Frontend\PagesController@modification')->name('auto.model.modification');
        };
    }

    Route::get($brand . "-{model}-{modification}", 'Frontend\PagesController@modification')->name('auto.model.modification');

    Route::get($brand . "-{model}", 'Frontend\PagesController@model')->name('auto.' . $brand . '.model');
    Route::get($brand, 'Frontend\PagesController@brand');
}


Route::get(implode('-', [$brand, $model]).'-c-'.$categories, 'Frontend\CategoriesController@show')
    ->where('categories','^[a-zA-Z0-9-_\/]+$')->name('frontend.categories.show');
Route::get(implode('-', [$brand, $model, $modification]), 'Frontend\PagesController@modification')->name('auto.model.modification');
Route::get(implode('-', [$brand, $model]), 'Frontend\CategoriesController@index');
Route::get(implode('-', [$brand, $model]), 'Frontend\PagesController@model')->name('auto.model');

Route::get('change-current-car/{id}', 'Frontend\PagesController@changeCurrentCar')->name('garage-change-current-car');
Route::get('garage-remove-car/{id}', 'Frontend\PagesController@removeCar')->name('garage-change-current-car');

Route::post('set-car-year', 'Frontend\PagesController@setCarYear')->name('set-car-year');
