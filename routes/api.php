<?php
Route::post('login', 'AuthController@login');

Route::middleware(['auth'])->group(function () {

    Route::post('logout', 'AuthController@logout');

    Route::get('authors', 'AuthorController@index');
    Route::post('authors', 'AuthorController@store');
    Route::get('authors/{id}', 'AuthorController@show');
    Route::get('authors/{id}/edit', 'AuthorController@edit');
    Route::put('authors/{id}', 'AuthorController@update');
    Route::delete('authors/{author}', 'AuthorController@destroy');

});





