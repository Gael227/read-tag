<?php

namespace App\Http\Controllers;

use App\Models\Annotate;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $book = Book::all();
        $allTags = Annotate::pluck('tags')
            ->flatMap(fn ($t) => explode(' ', $t))
            ->unique()
            ->values()
            ->toArray();

        return view('book', compact('book', 'allTags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'jumlah_halaman' => 'required|numeric',
        ]);

        $book = Book::create([
            'judul' => strtoupper($request->judul),
            'jumlah_halaman' => $request->jumlah_halaman,
        ]);

        return redirect('book')->with('hasil', 'DATA BUKU BERHASIL DISUBMIT');
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        $annotates = $book->annotates()->orderBy('halaman', 'asc')->get();

        return view('book-detail', compact('book', 'annotates'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $annotates = Annotate::with('book')
            ->where('tags', 'like', '%'.$query.'%')
            ->orWhere('catatan', 'like', '%'.$query.'%')
            ->get();

        $book = Book::all();
        $searched = true;

        $allTags = Annotate::pluck('tags')      // mengambil data semua 'tags' dari semua baris tabel Annotate. dan disimpen dalam collection of strings
            ->flatMap(fn ($t) => explode(' ', $t))      // tiap string dipecah berdasarkan spasi jadi array kecil, lalu hasilnya digabung jadi 1 array
            ->unique()      // membuang duplikat jika ada
            ->values()      // reset index array jadi mulai dari 0 lagi
            ->toArray();

        return view('book', compact('book', 'annotates', 'searched', 'allTags'));
    }
}
