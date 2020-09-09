<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with([
            'category' => function ($query) {
                return $query->select('id', 'name');
            }
        ])
            ->latest()
            ->get(['id', 'category_id', 'title', 'image', 'created_at']);

        return $books;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        $book->authors()->attach($request->input('authors'));

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/books');

            $book->update([
                'image' => $path,
            ]);
        }

        return $book;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($book)
    {
        $book = Book::with([
            'category' => function ($query) {
                return $query->select(['id', 'name']);
            },
            'user' => function ($query) {
                return $query->select(['id', 'name']);
            },
            'authors' => function ($query) {
                return $query->select(['authors.id', 'name']);
            }
        ])->findOrFail($book);

        return $book;
    }

    function edit($book) {
        return Book::select('id', 'category_id', 'title', 'synopsis', 'image')->findOrFail($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'authors' => 'required|array',
            'authors.*' => 'exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string',
            'synopsis' => 'required|string',
            'image' => 'nullable|image',
        ]);

        $path = null;

        $book->update([
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'synopsis' => $request->input('synopsis'),
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/books');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response([], 204);
    }
}
