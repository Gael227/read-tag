<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annotate;
use App\Models\Book;
class AnnotateController extends Controller
{

    #STORE/CREATE
    public function store(Request $request) {
        $request->validate([
            'book_id'=>'required',
            'catatan'=>'required',
            'halaman'=>'required|numeric',
            'tags'=>'required',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($request->halaman > $book->jumlah_halaman) { #jika input halamannya lebih besar dari total halaman buku yg udah ditentukan
            return redirect()->route('book.show', $book->id)->with('hasil', "halaman tidak valid"); #mengalihkan user ke route book.show yg biasanya menampilkan detail data berdasarkan ID yg diberikan
        }

        $tags = $request->tags;     # $tags mengambil hasil input 'tags'
        $tags = str_replace(' ', '-', $tags);   #mengganti input ' ' atau spasi, menjadi '-'
        if (!str_starts_with($tags, '#')) {     #jika di depan nama tags tidak ada tanda #, maka otomatis akan menambahkan tanda #
            $tags = '#' . $tags;
        }

        $annotate = Annotate::create([
            'book_id'=>$request->book_id,
            'catatan'=>$request->catatan,
            'halaman'=>$request->halaman,
            'tags'=>$tags,
        ]);

        return redirect()->route('book.show', $book->id);
    }

    #EDIT
    public function edit($id) {
        $annotate = Annotate::findOrFail($id);
        $book = Book::all();
        return view('annotate-edit', compact('annotate', 'book'));
    }

    #UPDATE
    public function update(Request $request, $id) {
        $request->validate([
            'book_id'=>'required',
            'catatan'=>'required',
            'halaman'=>'required|numeric',
            'tags'=>'required',
        ]);

        $annotate = Annotate::findOrFail($id);
        $book = Book::findOrFail($request->book_id);

        if ($request->halaman > $book->jumlah_halaman) {
            return redirect()->route('book.show', $book->id)->with('hasil', "halaman tidak valid");
        }

        $tags = $request->tags;
        $tags = str_replace(' ', '-', $tags);
        if (!str_starts_with($tags, '#')) {
            $tags = '#' . $tags;
        }

        $annotate->update([
            'book_id'=>$request->book_id,
            'catatan'=>$request->catatan,
            'halaman'=>$request->halaman,
            'tags'=>$tags,
        ]);
        return redirect()->route('book.show', $book->id);
    }

    #DESTROY/DELETE
    public function destroy($id) {
        $annotate = Annotate::findOrFail($id);
        $annotate->delete();
        return redirect()->route('book.show', $annotate->book_id);
    }
}
