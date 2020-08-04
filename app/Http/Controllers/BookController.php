<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    function index() {
        $books = Book::with([
            'category' => function ($query) {
                return $query->select(['id', 'name']);
            }
        ])->get(['id', 'category_id', 'title', 'image', 'created_at']);

        return $books;
    }

    function store(Request $request) {
        $request->validate([
            'authors' => 'required|array',
            'authors.*' => 'exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string',
            'synopsis' => 'required|string',
            'image' => 'nullable|image',
        ]);

        $book = Book::create([
            'user_id' => auth()->user()->id,
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'synopsis' => $request->input('synopsis'),
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/books');

            $book->update([
                'image' => $path,
            ]);
        }

        $book->authors()->attach($request->input('authors'));

        return $book;
    }

    function show($id) {
        $book = Book::with([
            'user' => function ($query) {
                return $query->select(['id', 'name']);
            },
            'category' => function ($query) {
                return $query->select(['id', 'name']);
            },
            'authors' => function ($query) {
                return $query->select(['authors.id', 'name']);
            },
        ])->findOrFail($id);

        return $book;
    }

    function destroy($id) {
        $book = Book::findOrFail($id);

        $book->delete();

        return response([], 204);
    }

}
