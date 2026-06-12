<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Catatan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen transition-colors duration-300">
    <div class="mx-auto max-w-2xl px-6 py-8">
        <!-- Header -->
        <header class="mb-10 rounded-2xl bg-slate-50 dark:bg-slate-900 p-6 sm:p-8 shadow-sm dark:shadow-lg border border-slate-200 dark:border-slate-800 transition-colors duration-300">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold">Edit Catatan</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">Perbarui Catatan Buku</h1>
                    <p class="mt-2 text-slate-600 dark:text-slate-300">Ubah halaman, catatan, atau tag untuk anotasi yang sudah tersimpan</p>
                </div>
                <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 shadow-sm">
                    <p class="font-semibold">ID Buku: <span class="text-slate-900 dark:text-white">{{ $annotate->book_id }}</span></p>
                    <p class="text-xs mt-1 text-slate-600 dark:text-slate-400">Total: <span class="font-semibold">{{ $annotate->book->jumlah_halaman ?? '-' }}</span> halaman</p>
                </div>
            </div>
        </header>

        <!-- Edit Form Section -->
        <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 sm:p-8 shadow-sm dark:shadow-lg">
            <form action="/annotate/{{ $annotate->id }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                @php
                    $inputHalaman = old('halaman', $annotate->halaman);
                    $maxHalaman = $annotate->book->jumlah_halaman ?? null;
                @endphp

                @if (session('hasil'))
                    <div class="rounded-lg border border-sky-200 dark:border-sky-900 bg-sky-50 dark:bg-sky-950 px-5 py-4 text-sm text-sky-900 dark:text-sky-100">
                        ✓ {{ session('hasil') }}
                    </div>
                @endif

                <input type="hidden" name="book_id" value="{{ $annotate->book_id }}">

                <div class="grid gap-6 sm:grid-cols-2">
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Halaman</span>
                        <p class="mb-2 text-xs text-slate-500 dark:text-slate-400">Maksimum: {{ $maxHalaman ?? '—' }} halaman</p>
                        <input type="text" name="halaman" autocomplete="off" value="{{ $inputHalaman }}"
                            class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-slate-900 dark:text-white outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100 dark:focus:ring-sky-900"
                            placeholder="Nomor halaman" />
                        @if ($maxHalaman && $inputHalaman > $maxHalaman)
                            <p class="mt-2 text-sm font-semibold text-rose-600 dark:text-rose-400">⚠️ Halaman tidak valid. Maksimum {{ $maxHalaman }} halaman</p>
                        @endif
                        @error('halaman')
                            <p class="mt-2 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Tags</span>
                        <input type="text" name="tags" autocomplete="off" value="{{ old('tags', $annotate->tags) }}"
                            class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-slate-900 dark:text-white outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100 dark:focus:ring-sky-900"
                            placeholder="Pisahkan dengan koma" />
                        @error('tags')
                            <p class="mt-2 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </label>
                </div>

                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Catatan</span>
                    <textarea name="catatan" rows="7"
                        class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-4 text-slate-900 dark:text-white outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100 dark:focus:ring-sky-900"
                        placeholder="Tuliskan catatan Anda di sini">{{ old('catatan', $annotate->catatan) }}</textarea>
                    @error('catatan')
                        <p class="mt-2 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                </label>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between pt-6 border-t border-slate-200 dark:border-slate-800">
                    <a href="/book/{{ $annotate->book_id }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 px-6 py-3 text-sm font-semibold text-slate-700 dark:text-slate-300 transition">
                        ← Kembali ke Buku
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-sky-600 hover:bg-sky-700 dark:bg-sky-700 dark:hover:bg-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-md transition">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </form>
        </section>
    </div>

</html>
