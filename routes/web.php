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

use Illuminate\Support\Facades\DB;

Route::get('/', 'Frontend\PagesController@index')->name('frontend.index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//require_once ('admin.php');
//require_once ('frontend.php');
