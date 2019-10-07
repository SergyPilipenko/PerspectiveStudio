<?php
Route::group(['prefix' => 'test'], function() {
    Route::get('', 'TestController@index');
    Route::get('elastic', 'TestController@elastic');
});

Route::get('switch-locale/{locale}', 'LocaleController@switch')->name('switch-locale');

Route::get('c-{category}', 'Frontend\ProductCategoryController@productCategory')->name('frontend.product-categories.show');
Route::get('{product}.html', 'Frontend\ProductController@detail')->name('frontend.product.show');
Route::post('search', 'Frontend\ProductController@search');

Route::group(['prefix' => 'checkout', 'as' => 'frontend.checkout.'], function() {
    Route::get('/', 'Frontend\CheckoutController@index')->name('index');
    Route::post('save-order', 'Frontend\CheckoutController@saveOrder')->name('save-order');
});

Route::post('cart/add/{product}', 'Frontend\CartController@add')->name('frontend.cart.add');
Route::post('cart/change-item-quantity/{product}', 'Frontend\CartController@changeCartItemQuantity')->name('frontend.cart.change-quantiry');
Route::delete('cart/remove-cart-item/{product}', 'Frontend\CartController@destroyCartItem')->name('frontend.cart.remove');

Route::get('change-current-car/{id}', 'Frontend\PagesController@changeCurrentCar')->name('garage-change-current-car');
Route::get('garage-remove-car/{id}', 'Frontend\PagesController@removeCar')->name('garage-change-current-car');
Route::get('garage-clear', 'Frontend\PagesController@clearGarage')->name('garage-clear');

Route::get('{brand}-{model}-{modification}-{category}', 'Frontend\PagesController@category')->name('frontend.category');
Route::get('{brand}-{model}-{modification}', 'Frontend\PagesController@modification')->name('frontend.modification');
Route::get('{brand}-{model}', 'Frontend\PagesController@model')->name('frontend.model');
Route::get('{brand}', 'Frontend\PagesController@brand')->name('frontend.brand');



Route::post('set-car-year', 'Frontend\PagesController@setCarYear')->name('set-car-year');
