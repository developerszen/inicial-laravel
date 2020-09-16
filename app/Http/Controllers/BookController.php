<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $books = Book::with([
            'category' => function ($query) {
                return $query->select('id', 'name');
            }
        ])
            ->latest()
            ->when($request->has('title'), function ($query) use ($request) {
                $title = $request->query('title');
                $query->where('title', 'like', '%' . $title . '%');
            })
            ->when($request->has('author'), function ($query) use ($request) {

                $query->whereHas('authors', function ($query) use ($request) {
                    $author = $request->query('author');
                    $query->where('author_id', $author);
                });

            })
            ->when($request->has('category'), function ($query) use ($request) {
                $category = $request->query('category');
                $query->where('category_id', $category);

            })
            ->select(['id', 'category_id', 'title', 'image', 'created_at'])
            ->paginate(5);

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
                return $query->withFields();
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
        return Book::with([
            'category' => function ($query) {
                return $query->withFields();
            },
            'authors' => function ($query) {
                return $query->select(['authors.id', 'name']);
            }
        ])
        ->select('id', 'category_id', 'title', 'synopsis', 'image')
            ->findOrFail($book);

//        $book = Book::select('id', 'category_id', 'title', 'synopsis', 'image')->findOrFail($book);
//        $book->authors = $book->authors()->pluck('authors.id')->toArray();
//
//        return $book;
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
            Storage::delete($book->image);

            $path = $request->file('image')->store('images/books');
        }

        $book->update([
            'image' => $path,
        ]);

        $book->authors()->sync($request->input('authors'));

        return $book;
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

    function resources() {
        $categories = Category::latest()->get(['id', 'name']);
        $authors = Author::latest()->get(['id', 'name']);

        return response(compact('categories', 'authors'));
    }
}
