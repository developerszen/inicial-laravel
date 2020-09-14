<?php
Route::post('login', 'AuthController@login');
Route::post('request-password-recovery', 'UserController@requestPasswordRecovery');
Route::post('password-recovery', 'UserController@passwordRecovery');

Route::middleware(['auth', 'reset_token_verify'])->group(function () {

    Route::post('logout', 'AuthController@logout');

    Route::get('authors', 'AuthorController@index');
    Route::post('authors', 'AuthorController@store');
    Route::get('authors/{id}', 'AuthorController@show');
    Route::get('authors/{id}/edit', 'AuthorController@edit');
    Route::put('authors/{id}', 'AuthorController@update');
    Route::delete('authors/{author}', 'AuthorController@destroy');

    Route::get('categories', 'CategoryController@index');
    Route::post('categories', 'CategoryController@store');
    Route::get('categories/{id}', 'CategoryController@show');
    Route::get('categories/{id}/edit', 'CategoryController@edit');
    Route::put('categories/{id}', 'CategoryController@update');
    Route::delete('categories/{category}', 'CategoryController@destroy');

    Route::get('books/{book}/edit', 'BookController@edit');
    Route::apiResource('books', 'BookController');

});





