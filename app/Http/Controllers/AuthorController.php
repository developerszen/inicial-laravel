<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthorController extends Controller
{
    function index (Request $request) {
        $authors = Author::latest()
            ->when($request->has('name'), function ($query) use ($request) {
                $name = $request->query('name');
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->withCount('books')
            ->get(['id', 'name', 'created_at']);
        return $authors;
    }

    function store (Request $request) {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:80',
                'alpha_custom',
//                'unique:authors,name',
                Rule::unique('authors')
                ->where(function ($query) {
                    return $query->where('deleted_at', null);
                }),
//                function ($attribute, $value, $fail) {
//                    $regex = preg_match('/^[\pL\.\s]+$/u', $value);
//
//                    if ($regex) return;
//
//                    $fail(trans('validation.alpha_custom'));
//                }
            ],
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
            'name' => [
                'required',
                'string',
                'max:80',
                Rule::unique('authors')
                    ->where(function ($query) {
                        return $query->where('deleted_at', null);
                    })->ignore($id),
            ],
        ]);

        $author = Author::findOrFail($id);

        $author->update([
            'name' => $request->input('name'),
        ]);

        return $author;
    }

    function edit($id) {
        $author = Author::select('id', 'name')->findOrFail($id);
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
