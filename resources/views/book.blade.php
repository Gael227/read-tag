<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book Log</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen transition-colors duration-300">
    <div class="mx-auto max-w-6xl px-6 py-8">
        <!-- Header -->
        <header class="mb-10 rounded-2xl bg-slate-50 dark:bg-slate-900 p-6 sm:p-8 shadow-sm dark:shadow-lg border border-slate-200 dark:border-slate-800 transition-colors duration-300">
            <div class="flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold">Book Log</p>
                        <h1 class="mt-2 text-4xl font-bold text-slate-900 dark:text-white">Form Input Buku</h1>
                        <p class="mt-2 text-slate-600 dark:text-slate-300">Kelola dan catat buku bacaan Anda dengan mudah</p>
                    </div>
                    <button id="dark-mode-toggle" class="flex items-center justify-center w-12 h-12 rounded-lg bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-lg transition-colors duration-300">
                        🌙
                    </button>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3 px-4 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        <span class="text-sm text-slate-600 dark:text-slate-400">Total buku:</span>
                        <span class="text-lg font-bold text-slate-900 dark:text-white">{{ $book->count() }}</span>
                    </div>

                    <form action="{{ route('search.annotate') }}" method="GET" class="flex gap-2">
                        <div class="relative flex-1 sm:flex-auto">
                            <input type="text" name="q" id="search-input" autocomplete="off"
                                placeholder="Cari keyword/tags..."
                                class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2 text-sm text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100 dark:focus:ring-sky-900" />
                            <ul id="tag-suggestions"
                                class="absolute left-0 top-full z-10 mt-1 hidden w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 py-1 shadow-lg dark:shadow-slate-950">
                            </ul>
                        </div>
                        <button type="submit"
                            class="rounded-lg bg-sky-600 hover:bg-sky-700 dark:bg-sky-700 dark:hover:bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition">
                            Cari
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Form Input Section -->
        <section id="book-input-form" class="mb-10 hidden rounded-2xl bg-slate-50 dark:bg-slate-900 p-6 sm:p-8 shadow-sm dark:shadow-lg border border-slate-200 dark:border-slate-800 transition-all duration-300">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Tambah Buku Baru</h2>
            <form action="/book" method="POST" class="space-y-6">
                @csrf
                <div class="grid gap-6 sm:grid-cols-2">
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Judul</span>
                        <input type="text" name="judul" autocomplete="off"
                            class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-slate-900 dark:text-white outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100 dark:focus:ring-sky-900"
                            placeholder="Masukkan judul buku" />
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Total Halaman</span>
                        <input type="text" name="jumlah_halaman" autocomplete="off"
                            class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-slate-900 dark:text-white outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100 dark:focus:ring-sky-900"
                            placeholder="Jumlah halaman" />
                    </label>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-sky-600 hover:bg-sky-700 dark:bg-sky-700 dark:hover:bg-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-md transition">
                        Simpan Buku
                    </button>
                    <button type="button" id="close-form-btn"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-6 py-3 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition"
                        onclick="document.getElementById('book-input-form').classList.add('hidden'); document.getElementById('toggle-form-btn').textContent = '+ Tambah Buku'; document.getElementById('toggle-form-btn').classList.add('bg-sky-600', 'hover:bg-sky-700'); document.getElementById('toggle-form-btn').classList.remove('bg-slate-600', 'hover:bg-slate-700');">
                        Batal
                    </button>
                </div>
            </form>
        </section>

        <!-- Toggle Form Button -->
        <div class="mb-10 flex gap-3">
            <button id="toggle-form-btn"
                class="inline-flex items-center justify-center rounded-lg bg-sky-600 hover:bg-sky-700 px-6 py-3 text-sm font-semibold text-white shadow-md transition">
                + Tambah Buku
            </button>
        </div>

        @if (isset($searched) && $searched)
            <!-- Search Results -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Hasil Pencarian</h2>
                        <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Ditemukan hasil yang sesuai dengan pencarian Anda</p>
                    </div>
                    <a href="/book"
                        class="inline-flex items-center justify-center rounded-lg bg-slate-600 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600 px-4 py-2 text-sm font-semibold text-white transition">
                        Tampilkan Semua
                    </a>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-slate-100 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300 uppercase text-xs tracking-wider">Halaman</th>
                                <th class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300 uppercase text-xs tracking-wider">Catatan</th>
                                <th class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300 uppercase text-xs tracking-wider">Tags</th>
                                <th class="px-6 py-4 font-semibold text-slate-700 dark:text-slate-300 uppercase text-xs tracking-wider">Dari Buku</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @forelse($annotates as $a)
                                <tr class="hover:bg-sky-50 dark:hover:bg-slate-800 transition">
                                    <td class="px-6 py-4 text-slate-700 dark:text-slate-300">{{ $a->halaman }}</td>
                                    <td class="px-6 py-4 text-slate-900 dark:text-white">{{ Str::limit($a->catatan, 50) }}</td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-slate-400 text-xs"><span class="inline-block bg-slate-200 dark:bg-slate-700 px-3 py-1 rounded-full">{{ $a->tags }}</span></td>
                                    <td class="px-6 py-4 text-slate-700 dark:text-slate-300">{{ $a->book->judul }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-slate-600 dark:text-slate-400">Tidak ada hasil ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <!-- Books List -->
            <section class="rounded-2xl bg-slate-50 dark:bg-slate-900 p-6 sm:p-8 shadow-sm dark:shadow-lg border border-slate-200 dark:border-slate-800">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Daftar Buku</h2>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-2">Klik pada buku untuk melihat detail dan menambahkan catatan</p>
                </div>

                @if($book->count() > 0)
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($book as $b)
                            <div class="group rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-5 shadow-sm hover:shadow-md hover:border-sky-300 dark:hover:border-sky-700 transition-all duration-300">
                                <a href="/book/{{ $b->id }}" class="block">
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-sky-600 dark:group-hover:text-sky-400 transition mb-3">
                                        {{ $b->judul }}
                                    </h3>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                                        📖 <span class="font-semibold">{{ $b->jumlah_halaman }}</span> halaman
                                    </p>
                                </a>

                                <div class="flex items-center gap-2 pt-4 border-t border-slate-200 dark:border-slate-700">
                                    <form action="/book/{{ $b->id }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus buku ini?')"
                                            class="rounded-lg bg-rose-600 hover:bg-rose-700 px-3 py-2 text-xs font-semibold text-white transition">
                                            🗑️ Hapus
                                        </button>
                                    </form>

                                    <a href="/book/{{ $b->id }}/edit"
                                        class="inline-flex rounded-lg bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 px-3 py-2 text-xs font-semibold text-slate-700 dark:text-slate-300 transition">
                                        ✏️ Edit
                                    </a>

                                    <a href="/book/{{ $b->id }}"
                                        class="ml-auto inline-flex items-center rounded-lg bg-sky-600 hover:bg-sky-700 px-3 py-2 text-xs font-semibold text-white transition">
                                        👁️ Detail →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-slate-500 dark:text-slate-400 text-lg">📚 Belum ada buku. Mulai tambahkan buku pertama Anda!</p>
                    </div>
                @endif
            </section>
        @endif
    </div>

    <script>
        const allTags = @json($allTags);
    </script>
</body>

</html>
