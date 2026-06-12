<?php
namespace App\Http\Controllers;

use App\Models\Annotate;
use App\Models\Book;
use Illuminate\Http\Request;

class AnnotateController extends Controller
{
    /**
     * Store a newly created annotate in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required',
            'catatan' => 'required',
            'halaman' => 'required|numeric',
            'tags'    => 'required',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        // Validasi halaman tidak melebihi jumlah halaman buku
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
            'tags'    => $tags,
        ]);

        return redirect()->route('book.show', $book->id);
    }

    /**
     * Show the form for editing the specified annotate.
     */
    public function edit($id)
    {
        $annotate = Annotate::with('book')->findOrFail($id);

        return view('annotate-edit', compact('annotate'));
    }

    /**
     * Update the specified annotate in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'book_id' => 'required',
            'catatan' => 'required',
            'halaman' => 'required|numeric',
            'tags'    => 'required',
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
            'tags'    => $tags,
        ]);

        return redirect()->route('book.show', $book->id);
    }

    /**
     * Remove the specified annotate from storage.
     */
    public function destroy($id)
    {
        $annotate = Annotate::findOrFail($id);
        $annotate->delete();

        return redirect()->route('book.show', $annotate->book_id);
    }

    /**
     * Normalize tags: replace spaces with hyphens and ensure it starts with '#'.
     */
    protected function normalizeTags(string $tags): string
    {
        $tags = str_replace(' ', '-', $tags);
        return str_starts_with($tags, '#') ? $tags : '#'.$tags;
    }
}
