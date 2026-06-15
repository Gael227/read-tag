<?php

namespace App\Http\Controllers;

use App\Models\Annotate;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Menampilkan daftar semua buku beserta tag unik.
     *
     * Digunakan untuk halaman utama manajemen buku.
     */
    public function index(): View
    {
        $books = Book::all();
        $allTags = $this->getAllUniqueTags();

        return view('book', compact('books', 'allTags'));
    }

    /**
     * Menyimpan buku baru ke dalam database.
     *
     * Judul buku akan otomatis dikonversi ke huruf kapital.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jumlah_halaman' => 'required|integer|min:1',
        ]);

        Book::create([
            'judul' => strtoupper($validated['judul']),
            'jumlah_halaman' => $validated['jumlah_halaman'],
        ]);

        return redirect('book')->with('hasil', 'DATA BUKU BERHASIL DISUBMIT');
    }

    /**
     * Menampilkan form edit untuk buku tertentu.
     *
     * Route model binding secara otomatis mengambil buku berdasarkan ID.
     */
    public function edit(Book $book): View
    {
        return view('book-edit', compact('book'));
    }

    /**
     * Memperbarui data buku yang sudah ada.
     *
     * Judul buku akan dikonversi ke huruf kapital sebelum disimpan.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jumlah_halaman' => 'required|integer|min:1',
        ]);

        $book->update([
            'judul' => strtoupper($validated['judul']),
            'jumlah_halaman' => $validated['jumlah_halaman'],
        ]);

        return redirect('book')->with('hasil', 'DATA BUKU BERHASIL DIPERBARUI');
    }

    /**
     * Menampilkan detail buku beserta anotasi-anotasinya.
     *
     * Anotasi diurutkan berdasarkan nomor halaman secara ascending.
     */
    public function show(Book $book): View
    {
        $annotates = $book->annotates()
            ->orderBy('halaman', 'asc')
            ->get();

        return view('book-detail', compact('book', 'annotates'));
    }

    /**
     * Mencari anotasi berdasarkan tag atau isi catatan.
     *
     * Hasil pencarian akan menampilkan semua buku dan tag unik
     * untuk memungkinkan filter ulang.
     */
    public function search(Request $request): View
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
     * Menghapus buku beserta semua anotasinya.
     *
     * Anotasi akan dihapus terlebih dahulu sebelum buku dihapus
     * untuk menjaga integritas data referensial.
     */
    public function destroy(Book $book): RedirectResponse
    {
        $book->annotates()->delete();
        $book->delete();

        return redirect('book')->with('hasil', 'DATA BUKU BERHASIL DIHAPUS');
    }

    /**
     * Mengambil semua tag unik dari semua anotasi.
     *
     * Tag dipisahkan menggunakan spasi sebagai delimiter.
     * Hasil dikembalikan sebagai array dengan nilai unik.
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

