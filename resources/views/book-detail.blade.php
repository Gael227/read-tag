<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $book->judul }} — Book Log</title>
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

        #annotate-form-wrap {
            display: grid;
            grid-template-rows: 0fr;
            opacity: 0;
            transition: grid-template-rows 0.3s ease, opacity 0.25s ease, margin 0.3s ease;
            overflow: hidden;
            margin-bottom: 0;
        }

        #annotate-form-wrap.open {
            grid-template-rows: 1fr;
            opacity: 1;
            margin-bottom: 2rem;
        }

        #annotate-form-wrap>.inner {
            min-height: 0;
        }

        .annotate-card {
            transition: border-color 0.2s ease;
        }

        .annotate-card:hover {
            border-color: rgb(161 161 170 / 0.6);
        }

        .dark .annotate-card:hover {
            border-color: rgb(63 63 70 / 0.8);
        }

        .tag-pill {
            display: inline-block;
            font-size: 0.68rem;
            font-weight: 500;
            letter-spacing: 0.03em;
            padding: 2px 8px;
            border-radius: 999px;
        }

        .page-num {
            font-variant-numeric: tabular-nums;
            font-feature-settings: "tnum";
        }
    </style>
</head>

<body class="bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 min-h-screen antialiased">

    {{-- NAV --}}
    <nav
        class="sticky top-0 z-30 border-b border-zinc-200 dark:border-zinc-800 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md">
        <div class="mx-auto max-w-5xl px-6 h-14 flex items-center justify-between">
            <div class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
                <a href="/book"
                    class="hover:text-zinc-900 dark:hover:text-zinc-100 transition font-medium">read-log</a>
                <span>/</span>
                <span class="text-zinc-900 dark:text-zinc-100 font-medium truncate max-w-xs">{{ $book->judul }}</span>
            </div>
            <div class="flex items-center gap-2">
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
            <p class="text-xs uppercase tracking-widest text-zinc-400 dark:text-zinc-500 font-medium mb-2">Detail buku
            </p>
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-50 leading-snug">
                        {{ $book->judul }}
                    </h1>
                    <p class="text-xs text-zinc-400 dark:text-zinc-500 font-mono mt-1">{{ $book->jumlah_halaman }}
                        halaman · {{ $annotates->count() }} anotasi</p>
                </div>
                <button id="toggle-annotate-btn"
                    class="shrink-0 h-8 px-4 rounded-md bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-semibold hover:bg-zinc-700 dark:hover:bg-zinc-300 transition">
                    + Tambah catatan
                </button>
            </div>
        </div>

        {{-- FLASH MESSAGE --}}
        @if (session('hasil'))
            <div
                class="anim-fade-in mb-6 flex items-center gap-3 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                <span class="text-green-500">✓</span>
                {{ session('hasil') }}
            </div>
        @endif

        {{-- ADD ANNOTATION FORM (collapsed) --}}
        <div id="annotate-form-wrap">
            <div class="inner">
                <div
                    class="rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 p-6 mb-0">
                    <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 dark:text-zinc-500 mb-4">
                        Catatan baru</p>
                    <form action="/annotate" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <div class="grid gap-4 sm:grid-cols-3">
                            <label class="block">
                                <span
                                    class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Halaman</span>
                                <input type="number" name="halaman" autocomplete="off"
                                    class="w-full rounded-md border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-zinc-100 outline-none transition focus:border-zinc-500 dark:focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100 dark:focus:ring-zinc-800"
                                    placeholder="e.g. 142" />
                            </label>
                            <label class="block sm:col-span-2">
                                <span
                                    class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Tags</span>
                                <input type="text" name="tags" autocomplete="off"
                                    class="w-full rounded-md border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-zinc-100 outline-none transition focus:border-zinc-500 dark:focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100 dark:focus:ring-zinc-800"
                                    placeholder="#napoleon #plot" />
                            </label>
                        </div>
                        <label class="block">
                            <span
                                class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Catatan</span>
                            <textarea name="catatan" rows="4" autocomplete="off"
                                class="w-full rounded-md border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-zinc-100 outline-none transition focus:border-zinc-500 dark:focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100 dark:focus:ring-zinc-800 resize-none"
                                placeholder="Tulis catatanmu…"></textarea>
                        </label>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="h-8 px-4 rounded-md bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-semibold hover:bg-zinc-700 dark:hover:bg-zinc-300 transition">
                                Simpan
                            </button>
                            <button type="button" id="close-annotate-btn"
                                class="h-8 px-4 rounded-md border border-zinc-300 dark:border-zinc-700 text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ANNOTATIONS --}}
        <div class="anim-fade-up anim-delay-1">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Anotasi</h2>
                <span class="text-xs text-zinc-400 dark:text-zinc-500">Diurutkan berdasarkan halaman</span>
            </div>

            @if ($annotates->count() > 0)
                <div class="space-y-3">
                    @foreach ($annotates as $index => $a)
                        <div
                            class="annotate-card anim-fade-up anim-delay-{{ min($index + 1, 3) }} rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5">
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span
                                        class="page-num text-xs font-mono font-semibold text-zinc-400 dark:text-zinc-500 bg-zinc-100 dark:bg-zinc-800 px-2 py-0.5 rounded">
                                        hal. {{ $a->halaman }}
                                    </span>
                                    @if ($a->halaman > $book->jumlah_halaman)
                                        <span
                                            class="tag-pill bg-rose-100 dark:bg-rose-950 text-rose-600 dark:text-rose-400">⚠
                                            invalid</span>
                                    @endif
                                    @if ($a->tags)
                                        <span
                                            class="tag-pill bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400">{{ $a->tags }}</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <a href="/annotate/{{ $a->id }}/edit"
                                        class="h-7 px-2.5 flex items-center rounded-md border border-zinc-200 dark:border-zinc-700 text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition text-xs">
                                        Edit
                                    </a>
                                    <form action="/annotate/{{ $a->id }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus catatan ini?')"
                                            class="h-7 px-2.5 flex items-center rounded-md border border-zinc-200 dark:border-zinc-700 text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950 hover:border-rose-200 dark:hover:border-rose-800 transition text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-relaxed">{{ $a->catatan }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    class="anim-fade-in rounded-xl border border-dashed border-zinc-300 dark:border-zinc-700 py-16 text-center">
                    <p class="text-sm text-zinc-400 dark:text-zinc-500">Belum ada catatan untuk buku ini.</p>
                    <button onclick="document.getElementById('toggle-annotate-btn').click()"
                        class="mt-3 text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition underline underline-offset-2">
                        Tambah catatan pertama →
                    </button>
                </div>
            @endif
        </div>

    </main>
</body>

</html>
