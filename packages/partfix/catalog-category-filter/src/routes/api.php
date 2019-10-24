<?php

Route::group(['prefix' => 'catalog/category/', 'as' => 'catalog.category.filter.'], function(){
    Route::post('filterqty', 'Api\CategoryFilterController@filterqty')->name('filterqty');
});
