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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

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
});

