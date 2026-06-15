<?php

namespace App\Http\Controllers;

use App\Models\Annotate;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AnnotateController extends Controller
{
    /**
     * Menyimpan anotasi baru untuk buku tertentu.
     *
     * Validasi nomor halaman agar tidak melebihi jumlah halaman buku.
     * Tag akan dinormalisasi (diganti spasi dengan hyphen, ditambah awalan #).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'catatan' => 'required|string',
            'halaman' => 'required|integer|min:1',
            'tags' => 'required|string',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if ($validated['halaman'] > $book->jumlah_halaman) {
            return redirect()
                ->route('book.show', $book->id)
                ->with('hasil', 'halaman tidak valid');
        }

        $tags = $this->normalizeTags($validated['tags']);

        Annotate::create([
            'book_id' => $validated['book_id'],
            'catatan' => $validated['catatan'],
            'halaman' => $validated['halaman'],
            'tags' => $tags,
        ]);

        return redirect()->route('book.show', $book->id);
    }

    /**
     * Menampilkan form edit untuk anotasi tertentu.
     *
     * Menggunakan eager loading untuk relasi buku.
     */
    public function edit(int $id): View
    {
        $annotate = Annotate::with('book')->findOrFail($id);

        return view('annotate-edit', compact('annotate'));
    }

    /**
     * Memperbarui data anotasi yang sudah ada.
     *
     * Validasi halaman dilakukan kembali untuk memastikan
     * tidak melebihi jumlah halaman buku yang bersangkutan.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'catatan' => 'required|string',
            'halaman' => 'required|integer|min:1',
            'tags' => 'required|string',
        ]);

        $book = Book::findOrFail($validated['book_id']);
        $annotate = Annotate::findOrFail($id);

        if ($validated['halaman'] > $book->jumlah_halaman) {
            return redirect()
                ->back()
                ->withInput()
                ->with('hasil', 'Halaman tidak valid. Maksimum ' . $book->jumlah_halaman . ' halaman.');
        }

        $tags = $this->normalizeTags($validated['tags']);

        $annotate->update([
            'book_id' => $validated['book_id'],
            'catatan' => $validated['catatan'],
            'halaman' => $validated['halaman'],
            'tags' => $tags,
        ]);

        return redirect()->route('book.show', $book->id);
    }

    /**
     * Menghapus anotasi dari database.
     *
     * Setelah dihapus, akan redirect ke halaman detail buku
     * tempat anotasi tersebut berada.
     */
    public function destroy(int $id): RedirectResponse
    {
        $annotate = Annotate::findOrFail($id);
        $bookId = $annotate->book_id;
        $annotate->delete();

        return redirect()->route('book.show', $bookId);
    }

    /**
     * Normalisasi tag agar konsisten.
     *
     * - Mengganti spasi dengan hyphen
     * - Menambahkan awalan '#' jika belum ada
     */
    protected function normalizeTags(string $tags): string
    {
        $tags = str_replace(' ', '-', $tags);
        return str_starts_with($tags, '#') ? $tags : '#' . $tags;
    }
}
