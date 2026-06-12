<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Buku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen transition-colors duration-300">
    <div class="mx-auto max-w-6xl px-6 py-8">
        <!-- Header -->
        <header class="mb-10 rounded-2xl bg-slate-50 dark:bg-slate-900 p-6 sm:p-8 shadow-sm dark:shadow-lg border border-slate-200 dark:border-slate-800 transition-colors duration-300">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold">Book Log</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">Detail Buku</h1>
                    <p class="mt-2 text-slate-600 dark:text-slate-300">Tambah catatan dan lihat annotasi buku secara langsung</p>
                </div>
                <a href="/book"
                    class="inline-flex items-center justify-center rounded-lg bg-slate-900 dark:bg-slate-700 hover:bg-slate-800 dark:hover:bg-slate-600 px-5 py-3 text-sm font-semibold text-white transition">
                    ← Kembali ke Daftar
                </a>
            </div>
        </header>

        @if (session('hasil'))
            <div class="mb-8 rounded-lg border border-sky-200 dark:border-sky-900 bg-sky-50 dark:bg-sky-950 px-6 py-4 text-slate-900 dark:text-sky-100 shadow-sm">
                <p class="font-medium">✓ {{ session('hasil') }}</p>
            </div>
        @endif

        <!-- Book Info & Form Container -->
        <div class="grid gap-8 lg:grid-cols-3 mb-10">
            <!-- Book Info Section -->
            <div class="lg:col-span-2 space-y-4">
                <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold">Judul Buku</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">{{ $book->judul }}</h2>
                </div>
                <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold">Total Halaman</p>
                    <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">{{ $book->jumlah_halaman }} 📖</p>
                </div>
            </div>

            <!-- Add Annotation Form -->
            <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 p-6 shadow-sm h-fit">
                <p class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold">Tambah Annotasi</p>
                <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">Isi form di bawah untuk menambahkan catatan pada buku ini</p>
                <div class="mt-4 w-full h-1 bg-gradient-to-r from-sky-400 to-sky-600 rounded-full"></div>
            </div>
        </div>

        <!-- Add Annotation Form Section -->
        <section class="mb-10 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 sm:p-8 shadow-sm dark:shadow-lg">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Form Tambah Catatan</h2>
            <form action="/annotate" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">

                <div class="grid gap-6 sm:grid-cols-3">
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Halaman</span>
                        <input type="number" name="halaman" autocomplete="off"
                            class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-slate-900 dark:text-white outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100 dark:focus:ring-sky-900"
                            placeholder="Nomor halaman" />
                    </label>
                    <label class="block sm:col-span-2">
                        <span class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Tags</span>
                        <input type="text" name="tags" autocomplete="off"
                            class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-slate-900 dark:text-white outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100 dark:focus:ring-sky-900"
                            placeholder="Pisahkan dengan koma" />
                    </label>
                </div>

                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Catatan</span>
                    <textarea name="catatan" rows="5"
                        class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-slate-900 dark:text-white outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100 dark:focus:ring-sky-900"
                        placeholder="Tulis catatan Anda"></textarea>
                </label>

                <div>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-sky-600 hover:bg-sky-700 dark:bg-sky-700 dark:hover:bg-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-md transition">
                        Simpan Catatan
                    </button>
                </div>
            </form>
        </section>

        <!-- Annotations List Section -->
        <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 sm:p-8 shadow-sm dark:shadow-lg">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Daftar Catatan</h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-2">Semua catatan yang tersimpan untuk buku ini</p>
            </div>

            @if($annotates->count() > 0)
                <div class="overflow-x-auto rounded-lg border border-slate-200 dark:border-slate-800">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-slate-100 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300 uppercase text-xs tracking-wider">Halaman</th>
                                <th class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300 uppercase text-xs tracking-wider">Catatan</th>
                                <th class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300 uppercase text-xs tracking-wider">Tags</th>
                                <th class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300 uppercase text-xs tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @forelse ($annotates as $a)
                                <tr class="hover:bg-sky-50 dark:hover:bg-slate-800 transition {{ $a->halaman > $book->jumlah_halaman ? 'bg-rose-50 dark:bg-rose-950' : '' }}">
                                    <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                                        <div class="flex items-center gap-2">
                                            <span>{{ $a->halaman }}</span>
                                            @if ($a->halaman > $book->jumlah_halaman)
                                                <span class="inline-flex items-center rounded-full bg-rose-100 dark:bg-rose-900 px-2 py-1 text-xs font-semibold text-rose-700 dark:text-rose-200">
                                                    ⚠️ Invalid
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-900 dark:text-white font-medium">{{ $a->catatan }}</td>
                                    <td class="px-6 py-4"><span class="inline-block bg-slate-200 dark:bg-slate-700 px-3 py-1 text-xs rounded-full text-slate-700 dark:text-slate-300">{{ $a->tags }}</span></td>
                                    <td class="px-6 py-4 space-x-2">
                                        <form action="/annotate/{{ $a->id }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus catatan ini?')"
                                                class="rounded-lg bg-rose-600 hover:bg-rose-700 px-3 py-2 text-xs font-semibold text-white transition">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                        <a href="/annotate/{{ $a->id }}/edit"
                                            class="inline-flex rounded-lg bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 px-3 py-2 text-xs font-semibold text-slate-700 dark:text-slate-300 transition">
                                            ✏️ Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-600 dark:text-slate-400">
                                        <p class="text-lg">📝 Belum ada catatan. Mulai tambahkan catatan pertama Anda!</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-slate-500 dark:text-slate-400 text-lg">📝 Belum ada catatan. Mulai tambahkan catatan pertama Anda!</p>
                </div>
            @endif
        </section>
    </div>

</html>
