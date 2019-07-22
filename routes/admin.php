<?php
Route::prefix('admin')->group(function() {

    Route::post('import/{id}/import_price', 'Admin\Import\ImportController@import_price')->name('admin.import.price');
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('import', 'Admin\Import\ImportController@index')->name('admin.import.index');
    Route::get('import/create', 'Admin\Import\ImportController@create')->name('admin.import.create');
    Route::post('import/parse', 'Admin\Import\ImportController@parse')->name('admin.import.parse');
    Route::post('import/store', 'Admin\Import\ImportController@store')->name('admin.import.store');
    Route::delete('import/{id}/destroy', 'Admin\Import\ImportController@destroy')->name('admin.import.destroy');
    Route::get('import/{id}/edit', 'Admin\Import\ImportController@edit')->name('admin.import.edit');

    Route::prefix('upload-history')->group(function() {

        Route::get('/', 'Admin\Import\UploadHistory@index')->name('admin.upload-history.index');

    });

    Route::prefix('catalog')->group(function() {
        Route::get('/', 'Admin\Catalog\CatalogController@index')->name('admin.catalog.index');
        Route::get('/{import_setting}/show', 'Admin\Catalog\CatalogController@show')->name('admin.catalog.show');
        Route::post('/{import_setting}/errors/add-mapping', 'Admin\Catalog\CatalogController@addMapping')->name('admin.catalog.errors.add-mapping');

        Route::get('/{import_setting}/errors', 'Admin\Catalog\CatalogController@catalogErrors')->name('admin.catalog.errors');
    });

});