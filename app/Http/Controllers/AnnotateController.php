<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annotate;
use App\Models\Book;
class AnnotateController extends Controller
{
    public function index() {
        $annotate = Annotate::all();
        $books = Book::all();
        return view('/annotate', compact('annotate', 'books'));
    }

    public function store(Request $request) {
        $request->validate([
            'book_id'=>'required',
            'catatan'=>'required',
            'halaman'=>'required|numeric',
            'tags'=>'required',
        ]);
    }
}
