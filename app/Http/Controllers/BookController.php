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

        $book = Book::create([
            'judul'=>strtoupper($request->judul),
            'jumlah_halaman'=> $request->jumlah_halaman,
        ]);
        return redirect('book')->with('hasil', "DATA BUKU BERHASIL DISUBMIT");
    }

    public function show($id) {
        $book = Book::findOrFail($id);
        $annotates = $book->annotates()->orderBy('halaman', 'asc')->get();

        return view('book-detail', compact('book', 'annotates'));
    }
}
