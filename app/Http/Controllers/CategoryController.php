<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function index () {
        $categories = Category::get(['id', 'name', 'created_at']);
        return $categories;
    }

    function store (Request $request) {
        $request->validate([
            'name' => 'required|string',
        ]);

        $category = Category::create([
            'name' => $request->input('name'),
        ]);

        return $category;
    }

    function show ($id) {
        $category = Category::findOrFail($id);

        return $category;
    }

    function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string',
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->input('name'),
        ]);

        return $category;
    }

    function destroy ($id) {
        $category = Category::findOrFail($id);

        $category->delete();

        return response([], 204);
    }
}
