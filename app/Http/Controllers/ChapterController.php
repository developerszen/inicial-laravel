<?php

namespace App\Http\Controllers;

use App\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    function index (Request $request) {
        //
    }

    function store(Request $request) {
        $request->validate([
            'fk_book' => 'required|exists:books,id',
            'title' => 'required',
            'body' => 'required'
        ]);

        $chapter = Chapter::create([
           'fk_book' => $request->input('fk_book'),
           'title' => $request->input('title'),
           'body' => $request->input('body'),
        ]);

        return $chapter;
    }

    function show($capitulo) {
        $chapter = Chapter::with('book')->findOrFail($capitulo);

        return $chapter;
    }
}
