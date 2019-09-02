<?php
Route::prefix('admin')->group(function() {
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.submit');

    Route::group(['prefix' => 'import', 'as' => 'admin.import.'], function() {
        Route::post('/{id}/import_price', 'Admin\Import\ImportController@import_price')->name('price');
        Route::get('/', 'Admin\Import\ImportController@index')->name('index');
        Route::post('/parse', 'Admin\Import\ImportController@parse')->name('parse');
        Route::post('/store', 'Admin\Import\ImportController@store')->name('store');
        Route::get('/{id}/edit', 'Admin\Import\ImportController@edit')->name('edit');
    });


    Route::prefix('upload-history')->group(function() {

        Route::get('/', 'Admin\Import\UploadHistory@index')->name('admin.upload-history.index');

    });

    Route::group(['prefix' => 'catalog', 'as' => 'admin.catalog.'], function() {
        Route::group(['prefix' => 'products', 'as' => 'products.'], function() {
            Route::get('/', 'Admin\Catalog\ProductsController@index')->name('index');
            Route::get('create', 'Admin\Catalog\ProductsController@create')->name('create');
        });

        Route::group(['prefix' => 'attributes', 'as' => 'attributes.'], function() {
            Route::get('/', 'Admin\Catalog\Attributes\AttributesController@index')->name('index');
            Route::get('create', 'Admin\Catalog\Attributes\AttributesController@create')->name('create');
            Route::post('store', 'Admin\Catalog\Attributes\AttributesController@store')->name('store');
            Route::get('{attribute}/edit', 'Admin\Catalog\Attributes\AttributesController@edit')->name('edit');
            Route::put('{attribute}/update', 'Admin\Catalog\Attributes\AttributesController@update')->name('update');
            Route::delete('{attribute}/destroy', 'Admin\Catalog\Attributes\AttributesController@destroy')->name('destroy');
        });

        Route::group(['prefix' => 'attribute-families', 'as' => 'attribute-families.'], function() {
            Route::get('/', 'Admin\Catalog\Attributes\AttributeFamiliesController@index')->name('index');
            Route::get('create', 'Admin\Catalog\Attributes\AttributeFamiliesController@create')->name('create');

            Route::group(['prefix' => 'attribute-groups', 'as' => 'attribute-groups.'], function() {
                Route::post('store', 'Admin\Catalog\Attributes\AttributeGroupsController@store')->name('store');
            });
        });

        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function() {
            Route::get('create', 'Admin\Catalog\CategoriesController@create')->name('create');
            Route::post('store', 'Admin\Catalog\CategoriesController@store')->name('store');
            Route::get('{category}/edit', 'Admin\Catalog\CategoriesController@edit')->name('edit');
            Route::put('{category}/update', 'Admin\Catalog\CategoriesController@update')->name('update');
            Route::delete('{id}/destroy', 'Admin\Catalog\CategoriesController@destroy')->name('destroy');
            Route::get('{category}/create', 'Admin\Catalog\CategoriesController@create')->name('create-subcategory');
            Route::post('{category}/store', 'Admin\Catalog\CategoriesController@store')->name('store-subcategory');
        });
    });

    Route::prefix('tecdoc')->group(function () {
        Route::prefix('products/')->group(function () {
            Route::get('/', 'Admin\Products\ProductsController@index')->name('admin.products.index');
            Route::get('{id}/edit', 'Admin\Products\ProductsController@edit')->name('admin.products.edit');
        });
        Route::prefix('categories')->group(function () {
            Route::get('/', 'Admin\Tecdoc\CategoriesController@index')->name('admin.tecdoc.categories.index');
            Route::get('create', 'Admin\Tecdoc\CategoriesController@create')->name('admin.tecdoc.categories.create');
            Route::post('store', 'Admin\Tecdoc\CategoriesController@store')->name('admin.tecdoc.categories.store');
            Route::delete('{category}/destroy', 'Admin\Tecdoc\CategoriesController@destroy')->name('admin.tecdoc.categories.destroy');
            Route::get('{category}/create', 'Admin\Tecdoc\CategoriesController@create')->name('admin.tecdoc.categories.create-subcategory');
            Route::post('{category}/store', 'Admin\Tecdoc\CategoriesController@store')->name('admin.tecdoc.categories.store-subcategory');
            Route::get('{category}/edit', 'Admin\Tecdoc\CategoriesController@edit')->name('admin.tecdoc.categories.edit');
            Route::post('{category}/add-or-change-image', 'Admin\Tecdoc\CategoriesController@addOrChangeImage')->name('admin.tecdoc.categories.image');
            Route::put('{category}/update', 'Admin\Tecdoc\CategoriesController@update')->name('admin.tecdoc.categories.update');
        });
        Route::prefix('auto')->group(function() {
            Route::get('/', 'Admin\Auto\AutoController@index')->name('admin.auto.index');
            Route::post('/store', 'Admin\Auto\AutoController@store')->name('admin.auto.store');
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




});
