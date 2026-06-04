<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annotate;
use App\Models\Book;
class AnnotateController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'book_id'=>'required',
            'catatan'=>'required',
            'halaman'=>'required|numeric',
            'tags'=>'required',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($request->halaman > $book->jumlah_halaman) {
            return redirect()->route('book.show', $book->id)->with('hasil', "halaman tidak valid"); #mengalihkan user ke route book.show yg biasanya menampilkan detail data berdasarkan ID yg diberikan
        }

        $annotate = Annotate::create($request->all());
        return redirect()->route('book.show', $book->id);
    }

    public function edit($id) {
        $annotate = Annotate::findOrFail($id);
        $book = Book::all();
        return view('annotate-edit', compact('annotate', 'book'));
    }

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

        $annotate->update($request->all());
        return redirect()->route('book.show', $book->id);
    }

    public function destroy($id) {
        $annotate = Annotate::findOrFail($id);
        $annotate->delete();
        return redirect()->route('book.show', $annotate->book_id);
    }
}
