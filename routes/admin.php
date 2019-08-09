<?php
Route::prefix('admin')->group(function() {

    Route::post('import/{id}/import_price', 'Admin\Import\ImportController@import_price')->name('admin.import.price');
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('import', 'Admin\Import\ImportController@index')->name('admin.import.index');
    Route::post('import/parse', 'Admin\Import\ImportController@parse')->name('admin.import.parse');
    Route::post('import/store', 'Admin\Import\ImportController@store')->name('admin.import.store');
    Route::get('import/{id}/edit', 'Admin\Import\ImportController@edit')->name('admin.import.edit');

    Route::prefix('upload-history')->group(function() {

        Route::get('/', 'Admin\Import\UploadHistory@index')->name('admin.upload-history.index');

    });

    Route::prefix('categories')->group(function () {
        Route::get('/', 'Admin\Catalog\CategoriesController@index')->name('admin.categories.index');
        Route::get('create', 'Admin\Catalog\CategoriesController@create')->name('admin.categories.create');
        Route::post('store', 'Admin\Catalog\CategoriesController@store')->name('admin.categories.store');
        Route::delete('{category}/destroy', 'Admin\Catalog\CategoriesController@destroy')->name('admin.categories.destroy');
        Route::get('{category}/create', 'Admin\Catalog\CategoriesController@create')->name('admin.categories.create-subcategory');
        Route::post('{category}/store', 'Admin\Catalog\CategoriesController@store')->name('admin.categories.store-subcategory');
        Route::get('{category}/edit', 'Admin\Catalog\CategoriesController@edit')->name('admin.categories.edit');
        Route::post('{category}/add-or-change-image', 'Admin\Catalog\CategoriesController@addOrChangeImage')->name('admin.categories.image');
        Route::put('{category}/update', 'Admin\Catalog\CategoriesController@update')->name('admin.categories.update');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', 'Admin\Products\ProductsController@index')->name('admin.products.index');
        Route::get('{id}/edit', 'Admin\Products\ProductsController@edit')->name('admin.products.edit');
    });
    Route::prefix('catalog')->group(function() {
        Route::get('/', 'Admin\Catalog\CatalogController@index')->name('admin.catalog.index');
        Route::get('/create', 'Admin\Import\ImportController@create')->name('admin.import.create');

        Route::get('/{import_setting}/diagnostics', 'Admin\Catalog\CatalogController@diagnostics')->name('admin.catalog.diagnostics');
        Route::get('/{import_setting}/prices', 'Admin\Catalog\CatalogController@prices')->name('admin.catalog.prices');
        Route::post('/{import_setting}/errors/add-mapping', 'Admin\Catalog\CatalogController@addMapping')->name('admin.catalog.errors.add-mapping');
        Route::get('/{import_setting}/errors', 'Admin\Catalog\CatalogController@catalogErrors')->name('admin.catalog.errors');
        Route::get('/{import_setting}/settings', 'Admin\Catalog\CatalogController@settings')->name('admin.catalog.settings');
        Route::post('/{import_setting}/update', 'Admin\Catalog\CatalogController@update')->name('admin.catalog.update');
        Route::delete('/{import_setting}/destroy', 'Admin\Catalog\CatalogController@destroy')->name('admin.catalog.destroy');
    });

});
