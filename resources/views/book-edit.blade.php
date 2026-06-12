<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Buku — Book Log</title>
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

        .anim-fade-up {
            animation: fadeUp 0.35s ease both;
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
                <span class="text-zinc-900 dark:text-zinc-100 font-medium truncate max-w-xs">edit buku</span>
            </div>
            <button id="dark-mode-toggle"
                class="h-8 w-8 flex items-center justify-center rounded-md border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition text-sm"
                aria-label="Toggle dark mode">
                🌙
            </button>
        </div>
    </nav>

    <main class="mx-auto max-w-2xl px-6 py-12">

        {{-- HERO --}}
        <div class="anim-fade-up mb-8">
            <p class="text-xs uppercase tracking-widest text-zinc-400 dark:text-zinc-500 font-medium mb-2">Edit buku</p>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-50">Perbarui Data Buku</h1>
        </div>

        {{-- FLASH --}}
        @if (session('hasil'))
            <div
                class="mb-6 flex items-center gap-3 rounded-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                <span class="text-green-500">✓</span>
                {{ session('hasil') }}
            </div>
        @endif

        {{-- FORM --}}
        <div
            class="anim-fade-up rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 sm:p-8">
            <form action="{{ route('book.update', $book->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="block">
                        <span class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Judul</span>
                        <input type="text" name="judul" autocomplete="off" value="{{ $book->judul }}"
                            class="w-full rounded-md border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-zinc-100 outline-none transition focus:border-zinc-500 dark:focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100 dark:focus:ring-zinc-800"
                            placeholder="Judul buku" />
                    </label>
                    <label class="block">
                        <span class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">Total
                            halaman</span>
                        <input type="number" name="jumlah_halaman" autocomplete="off"
                            value="{{ $book->jumlah_halaman }}"
                            class="w-full rounded-md border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm text-zinc-900 dark:text-zinc-100 outline-none transition focus:border-zinc-500 dark:focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100 dark:focus:ring-zinc-800"
                            placeholder="e.g. 500" />
                    </label>
                </div>

                <div class="flex items-center justify-between gap-3 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <a href="{{ route('book.index') }}"
                        class="h-8 px-4 flex items-center rounded-md border border-zinc-300 dark:border-zinc-700 text-xs font-medium text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                        ← Kembali
                    </a>
                    <button type="submit"
                        class="h-8 px-4 rounded-md bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-semibold hover:bg-zinc-700 dark:hover:bg-zinc-300 transition">
                        Simpan perubahan
                    </button>
                </div>
            </form>
        </div>

    </main>
</body>

</html>
