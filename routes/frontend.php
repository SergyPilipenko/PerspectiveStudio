<?php

Route::get('switch-locale/{locale}', 'LocaleController@switch')->name('switch-locale');

Route::get('c-{category}', 'Frontend\ProductCategoryController@productCategory')->name('frontend.product-categories.show');
Route::get('{product}.html', 'Frontend\ProductController@detail')->name('frontend.product.show');

Route::get('{brand}-{model}-{modification}-{category}', 'Frontend\PagesController@category')->name('frontend.category');
Route::get('{brand}-{model}-{modification}', 'Frontend\PagesController@modification')->name('frontend.modification');
Route::get('{brand}-{model}', 'Frontend\PagesController@model')->name('frontend.model');
Route::get('{brand}', 'Frontend\PagesController@brand')->name('frontend.brand');


Route::get('change-current-car/{id}', 'Frontend\PagesController@changeCurrentCar')->name('garage-change-current-car');
Route::get('garage-remove-car/{id}', 'Frontend\PagesController@removeCar')->name('garage-change-current-car');

Route::post('set-car-year', 'Frontend\PagesController@setCarYear')->name('set-car-year');
