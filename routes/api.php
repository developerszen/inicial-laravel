<?php



Route::get('authors', 'AuthorController@index');
Route::post('authors', 'AuthorController@store');