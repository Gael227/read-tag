<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index() {
        $book = Book::all();
        return view('book', compact('book'));
    }

    public function store(Request $request) {
        $request->validate([
            'judul'=>'required',
            'jumlah_halaman'=>'required|numeric',
        ]);

        $book = Book::create($request->all());
        return redirect('book')->with('hasil', "DATA BUKU BERHASIL DISUBMIT");
    }

    public function show(Book $book) {
        $book->load('annotate');

        return view('book-detail', compact('book', 'annotate'));
    }
}
