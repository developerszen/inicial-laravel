<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    function index() {
        $books = Book::with([
            'category' => function ($query) {
                return $query->select(['id', 'name']);
            }
        ])
            ->latest()
            ->get(['id', 'category_id', 'title', 'image', 'created_at']);

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

    function edit($id) {
        $book = Book::select('id', 'category_id', 'title', 'synopsis', 'image')->findOrFail($id);

        $book->authors = $book->authors()->pluck('authors.id')->toArray();

        return $book;
    }

    function update(Request $request, $id) {
        $request->validate([
            'authors' => 'required|array',
            'authors.*' => 'exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string',
            'synopsis' => 'required|string',
            'image' => 'nullable|image',
        ]);

        $path = null;
        $book = Book::findOrFail($id);

        $book->update([
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'synopsis' => $request->input('synopsis'),
        ]);

        if ($request->hasFile('image')) {
            Storage::delete($book->image);

            $path = $request->file('image')->store('images/books');
        }

        $book->update([
           'image' => $path,
        ]);

        $book->authors()->sync($request->input('authors'));

        return $book;
    }

    function destroy($id) {
        $book = Book::findOrFail($id);

        $book->delete();

        return response([], 204);
    }

    function resources() {
        $categories = Category::latest()->get(['id', 'name']);
        $authors = Author::latest()->get(['id', 'name']);

        return response()->json(compact('categories', 'authors'));
    }
}
