<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    function index () {
        $authors = Author::get(['id', 'name', 'created_at']);
        return $authors;
    }

    function store (Request $request) {
        $request->validate([
            'name' => 'required|string',
        ]);

        $author = Author::create([
            'name' => $request->input('name'),
        ]);

        return $author;
    }

    function show ($id) {
        $author = Author::findOrFail($id);

        return $author;
    }

    function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string',
        ]);

        $author = Author::findOrFail($id);

        $author->update([
            'name' => $request->input('name'),
        ]);

        return $author;
    }

    function destroy ($id) {
        $author = Author::findOrFail($id);

        $relation = $author->books;

        if (count($relation)) {
            return response()->json([
                'error' => 'integrity violation'
            ], 500);
        }

        $author->delete();

        return response([], 204);
    }
}
