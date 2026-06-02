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

        $books = Book::findOrFail($request->buku_id);

        if ($request->halaman > $books->jumlah_halaman) {
            return redirect('/annotate')->with('hasil', "halaman tidak valid");
        }

        $annotate = Annotate::create($request->all());
        return redirect('/annotate');
    }

    public function edit($id) {
        $annotate = Annotate::findOrFail($id);
        $books = Book::all();
        return view('annotate-edit', compact('annotate', 'books'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'book_id'=>'required',
            'catatan'=>'required',
            'halaman'=>'required|numeric',
            'tags'=>'required',
        ]);

        $annotate = Annotate::findOrFail($id);
        $books = Book::findOrFail($request->buku_id);

        if ($request->halaman > $books->jumlah_halaman) {
            return redirect('/annotate')->with('hasil', "halaman tidak valid");
        }

        $annotate->update($request->all());
        return redirect('/annotate');
    }

    public function destroy($id) {
        $annotate = Annotate::findOrFail($id);
        $annotate->delete();
        return redirect('/annotate');
    }
}
