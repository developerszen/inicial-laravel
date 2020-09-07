<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    function index () {
        $authors = Author::latest()->get(['id', 'name', 'created_at']);
        return $authors;
    }

    function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:80',
        ]);

        $author = Author::create([
            'name' => $request->input('name'),
        ]);

        return $author;
    }

    function show($id) {
        $author = Author::findOrFail($id);

        return $author;
    }

    function edit($id) {
        $author = Author::select('id', 'name')->findOrFail($id);

        return $author;
    }

    function update(Request $request, $id) {
        $request->validate([
           'name' => 'required|string|max:80'
        ]);

        $author = Author::findOrFail($id);

        $author->update([
            'name' => $request->input('name'),
        ]);

        return $author;
    }

    function destroy(Author $author) {
        $relation = $author->books;

        if(count($relation)) {
            return response([
                'error' => 'Integrity violation',
            ], 500);
        }

        $author->delete();

        return response([], 204);
    }
}
