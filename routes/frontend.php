<?php
Route::get('/', 'Frontend\PagesController@index')->name('frontend.index');

Route::get('switch-locale/{locale}', 'LocaleController@switch')->name('switch-locale');

Route::get('c-{category}', 'Frontend\ProductCategoryController@productCategory')->name('frontend.product-categories.show');
Route::get('r-{rubric}', 'Frontend\RubricController@index')->name('frontend.rubric.index');
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

Route::get('{brand}-{model}-{modification}-{category}', 'Frontend\PagesController@category')->name('frontend.car.category');
Route::get('{brand}-{model}-{modification}', 'Frontend\PagesController@modification')->name('frontend.modification');
Route::get('{brand}-{model}', 'Frontend\PagesController@model')->name('frontend.model');
Route::post('set-car-year', 'Frontend\PagesController@setCarYear')->name('set-car-year');
Route::any('getMenu', 'Frontend\MobileMenuController@index')->name('frontend.mobile-menu');
Route::get('spa', 'TestController@spa');
