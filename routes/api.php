<?php

use App\Author;

Route::get('authors', function () {
    $authors = Author::all();
    return $authors;
});
