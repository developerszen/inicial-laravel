<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    function index () {
        $authors = Author::all();
        return $authors;
    }

    function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
        ]);

        $author = Author::create([
            'name' => $request->input('name'),
        ]);

        return $author;
    }
}
