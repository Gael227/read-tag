<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book Log</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .anim-fade-up {
            animation: fadeUp 0.35s ease both;
        }

        .anim-fade-in {
            animation: fadeIn 0.25s ease both;
        }

        .anim-delay-1 {
            animation-delay: 0.05s;
        }

        .anim-delay-2 {
            animation-delay: 0.10s;
        }

        .anim-delay-3 {
            animation-delay: 0.15s;
        }

        #book-input-form {
            display: grid;
            grid-template-rows: 0fr;
            opacity: 0;
            transition: grid-template-rows 0.3s ease, opacity 0.25s ease, margin 0.3s ease;
            overflow: hidden;
            margin-bottom: 0;
        }

        #book-input-form.open {
            grid-template-rows: 1fr;
            opacity: 1;
            margin-bottom: 2.5rem;
        }

        #book-input-form>.inner {
            min-height: 0;
        }

        .book-card {
            transition: border-color 0.2s ease, transform 0.2s ease;
        }

        .book-card:hover {
            transform: translateY(-2px);
        }

        .tag-pill {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.03em;
            padding: 2px 8px;
            border-radius: 999px;
        }
    </style>
</head>

<body class="bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 min-h-screen antialiased">

    {{-- NAV --}}
    <nav
        class="sticky top-0 z-30 border-b border-zinc-200 dark:border-zinc-800 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md">
        <div class="mx-auto max-w-5xl px-6 h-14 flex items-center justify-between">
            <span class="text-sm font-semibold tracking-tight text-zinc-900 dark:text-zinc-100">read-log</span>
            <div class="flex items-center gap-3">
                {{-- Search --}}
                <form action="{{ route('search.annotate') }}" method="GET" class="flex items-center gap-2">
                    <div class="relative">
                        <input type="text" name="q" id="search-input" autocomplete="off"
                            placeholder="Cari tag atau catatan…"
                            class="h-8 w-52 rounded-md border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900 pl-3 pr-3 text-xs text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 outline-none transition focus:border-zinc-500 dark:focus:border-zinc-400 focus:ring-2 focus:ring-zinc-200 dark:focus:ring-zinc-700" />
                        <ul id="tag-suggestions"
                            class="absolute left-0 top-full z-50 mt-1 hidden w-full rounded-md border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 py-1 shadow-lg text-xs overflow-hidden">
                        </ul>
                    </div>
                    <button type="submit"
                        class="h-8 px-3 rounded-md border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-xs font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                        Cari
                    </button>
                </form>
                {{-- Dark mode toggle --}}
                <button id="dark-mode-toggle"
                    class="h-8 w-8 flex items-center justify-center rounded-md border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition text-sm"
                    aria-label="Toggle dark mode">
                    🌙
                </button>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-5xl px-6 py-12">

        {{-- HERO --}}
        <div class="anim-fade-up mb-10">
            <p class="text-xs uppercase tracking-widest text-zinc-400 dark:text-zinc-500 font-medium mb-2">Koleksi buku
            </p>
            <div class="flex items-end justify-between gap-4">
                <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-zinc-50">
                    Perpustakaan Saya
                </h1>
                <div class="flex items-center gap-2 shrink-0">
                    <span class="text-xs text-zinc-400 dark:text-zinc-500">{{ $book->count() }} buku</span>
                    <button id="toggle-form-btn"
                        class="h-8 px-4 rounded-md bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-semibold hover:bg-zinc-700 dark:hover:bg-zinc-300 transition">
                        + Tambah
                    </button>
                </div>
            </div>
        </div>

        {{-- FORM (collapsed by default) --}}
        <div id="book-input-form">
            <div class="inner">
                <div
                    class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 p-6 mb-0">
                    <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 dark:text-zinc-500 mb-4">
                        Buku baru</p>
                    <form action="/book" method="POST">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2 mb-4">
                            <label class="block">
                                <span
                                    class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Judul</span>
                                <input type="text" name="judul" autocomplete="off"
                                    class="w-full rounded-md border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-zinc-100 outline-none transition focus:border-zinc-500 dark:focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100 dark:focus:ring-zinc-800"
                                    placeholder="Judul buku" />
                            </label>
                            <label class="block">
                                <span class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Total
                                    halaman</span>
                                <input type="number" name="jumlah_halaman" autocomplete="off"
                                    class="w-full rounded-md border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-zinc-100 outline-none transition focus:border-zinc-500 dark:focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100 dark:focus:ring-zinc-800"
                                    placeholder="e.g. 500" />
                            </label>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="h-8 px-4 rounded-md bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-semibold hover:bg-zinc-700 dark:hover:bg-zinc-300 transition">
                                Simpan
                            </button>
                            <button type="button" id="close-form-btn"
                                class="h-8 px-4 rounded-md border border-zinc-300 dark:border-zinc-700 text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- SEARCH RESULTS --}}
        @if (isset($searched) && $searched)
            <div class="anim-fade-up mb-10">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-50">Hasil pencarian</h2>
                        <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-0.5">{{ $annotates->count() }} anotasi
                            ditemukan</p>
                    </div>
                    <a href="/book"
                        class="text-xs font-medium text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition underline underline-offset-2">
                        Lihat semua buku
                    </a>
                </div>

                <div class="rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900">
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 w-20">
                                    Hal.</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                    Catatan</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                    Tags</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                    Buku</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60 bg-white dark:bg-zinc-950">
                            @forelse($annotates as $a)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-900 transition">
                                    <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400 font-mono text-xs">
                                        {{ $a->halaman }}</td>
                                    <td class="px-4 py-3 text-zinc-800 dark:text-zinc-200 max-w-xs">
                                        {{ Str::limit($a->catatan, 60) }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="tag-pill bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300">{{ $a->tags }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400 text-xs">{{ $a->book->judul }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-4 py-10 text-center text-zinc-400 dark:text-zinc-500 text-sm">
                                        Tidak ada hasil ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- BOOK GRID --}}
        @else
            @if ($book->count() > 0)
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($book as $index => $b)
                        <div
                            class="book-card anim-fade-up anim-delay-{{ min($index + 1, 3) }} group rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 hover:border-zinc-400 dark:hover:border-zinc-600">
                            <a href="/book/{{ $b->id }}" class="block mb-4">
                                <h3
                                    class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 group-hover:text-zinc-600 dark:group-hover:text-zinc-300 transition leading-snug mb-1">
                                    {{ $b->judul }}
                                </h3>
                                <p class="text-xs text-zinc-400 dark:text-zinc-500 font-mono">{{ $b->jumlah_halaman }}
                                    hal.</p>
                            </a>
                            <div class="flex items-center gap-1.5 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                                <a href="/book/{{ $b->id }}"
                                    class="flex-1 h-7 flex items-center justify-center rounded-md bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-medium hover:bg-zinc-700 dark:hover:bg-zinc-300 transition">
                                    Buka →
                                </a>
                                <a href="/book/{{ $b->id }}/edit"
                                    class="h-7 w-7 flex items-center justify-center rounded-md border border-zinc-200 dark:border-zinc-700 text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition text-xs">
                                    ✏
                                </a>
                                <form action="/book/{{ $b->id }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus buku ini?')"
                                        class="h-7 w-7 flex items-center justify-center rounded-md border border-zinc-200 dark:border-zinc-700 text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950 hover:border-rose-200 dark:hover:border-rose-800 transition text-xs">
                                        ✕
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    class="anim-fade-in rounded-xl border border-dashed border-zinc-300 dark:border-zinc-700 py-20 text-center">
                    <p class="text-sm text-zinc-400 dark:text-zinc-500">Belum ada buku. Mulai tambahkan!</p>
                </div>
            @endif
        @endif

    </main>

    <script>
        window.allTags = @json($allTags);
    </script>
</body>

</html>
