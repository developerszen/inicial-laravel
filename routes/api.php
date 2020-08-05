<?php

Route::post('login', 'AuthController@login');

Route::middleware(['auth:api'])->group(function () {

    Route::post('users/verify-email', 'UserController@verifyEmail');

});

Route::middleware(['auth:api', 'email_verified'])->group(function () {

    Route::post('logout', 'AuthController@logout');

    Route::post('users', 'UserController@store');

    Route::get('authors', 'AuthorController@index');
    Route::post('authors', 'AuthorController@store');
    Route::get('authors/{id}', 'AuthorController@show');
    Route::put('authors/{id}', 'AuthorController@update');
    Route::delete('authors/{id}', 'AuthorController@destroy');

    Route::get('categories', 'CategoryController@index');
    Route::post('categories', 'CategoryController@store');
    Route::get('categories/{id}', 'CategoryController@show');
    Route::put('categories/{id}', 'CategoryController@update');
    Route::delete('categories/{id}', 'CategoryController@destroy');

    Route::get('books', 'BookController@index');
    Route::post('books', 'BookController@store');
    Route::get('books/resources', 'BookController@resources');
    Route::get('books/{id}/edit', 'BookController@edit');
    Route::get('books/{id}', 'BookController@show');
    Route::put('books/{id}', 'BookController@update');
    Route::delete('books/{id}', 'BookController@destroy');

});





