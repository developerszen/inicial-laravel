<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function index (Request $request) {
        $categories = Category::latest()
            ->withCount('book')
            ->when($request->has('name'), function ($query) use ($request) {
                $name = $request->query('name');
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->select(['id', 'name', 'created_at'])
            ->paginate(5);
        return $categories;
    }

    function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:80',
        ]);

        $category = Category::create([
            'name' => $request->input('name'),
        ]);

        return $category;
    }

    function show($id) {
        $category = Category::findOrFail($id);

        return $category;
    }

    function edit($id) {
        $category = Category::select('id', 'name')->findOrFail($id);

        return $category;
    }

    function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:80'
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->input('name'),
        ]);

        return $category;
    }

    function destroy(Category $category) {
        $relation = $category->book()->exists();

        if($relation) {
            return response([
                'error' => 'Integrity violation',
            ], 500);
        }

        $category->delete();

        return response([], 204);
    }
}
