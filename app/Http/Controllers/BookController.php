<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index() {
        $books = Book::all();
        return view('/book', compact('books'));
    }

    public function store(Request $request) {
        $request->validate([
            'judul'=>'required',
            'jumlah_halaman'=>'required|numeric',
        ]);

        $book = Book::create($request->all());
        return redirect('book')->with('hasil', "DATA BUKU BERHASIL DISUBMIT");
    }

    public function show($id) {
        $books = Book::findOrFail($id);
        $annotate = $books->annotate;

        return view('book-detail', compact('books', 'annotate'));
    }
}
