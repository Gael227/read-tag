<?php

namespace App\Http\Controllers;

use App\Models\Annotate;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display all books with unique tags.
     */
    public function index()
    {
        $books = Book::all();
        $allTags = $this->getAllUniqueTags();

        return view('book', compact('books', 'allTags'));
    }

    /**
     * Store a newly created book.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'jumlah_halaman' => 'required|numeric',
        ]);

        Book::create([
            'judul' => strtoupper($validated['judul']),
            'jumlah_halaman' => $validated['jumlah_halaman'],
        ]);

        return redirect('book')->with('hasil', 'DATA BUKU BERHASIL DISUBMIT');
    }

    /**
     * Show edit form for specific book.
     */
    public function edit(Book $book)
    {
        return view('book-edit', compact('book'));
    }

    /**
     * Update specified book.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'jumlah_halaman' => 'required|numeric',
        ]);

        $book->update([
            'judul' => strtoupper($validated['judul']),
            'jumlah_halaman' => $validated['jumlah_halaman'],
        ]);

        return redirect('book')->with('hasil', 'DATA BUKU BERHASIL DIPERBARUI');
    }

    /**
     * Display book details with its annotations.
     */
    public function show(Book $book)
    {
        $annotates = $book->annotates()->orderBy('halaman', 'asc')->get();

        return view('book-detail', compact('book', 'annotates'));
    }

    /**
     * Search annotations by tag or note content.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        $annotates = Annotate::with('book')
            ->where('tags', 'like', "%{$query}%")
            ->orWhere('catatan', 'like', "%{$query}%")
            ->get();

        $books = Book::all();
        $allTags = $this->getAllUniqueTags();

        return view('book', compact('books', 'annotates', 'allTags'))
            ->with('searched', true);
    }

    /**
     * Delete book and its annotations.
     */
    public function destroy(Book $book)
    {
        $book->annotates()->delete();
        $book->delete();

        return redirect('book')->with('hasil', 'DATA BUKU BERHASIL DIHAPUS');
    }

    /**
     * Get all unique tags from annotations.
     */
    private function getAllUniqueTags(): array
    {
        return Annotate::pluck('tags')
            ->flatMap(fn ($tags) => explode(' ', $tags))
            ->unique()
            ->values()
            ->toArray();
    }
}

