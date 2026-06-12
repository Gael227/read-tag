<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Buku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen transition-colors duration-300">
    <div class="mx-auto max-w-2xl px-6 py-8">
        <!-- Header -->
        <header class="mb-10 rounded-2xl bg-slate-50 dark:bg-slate-900 p-6 sm:p-8 shadow-sm dark:shadow-lg border border-slate-200 dark:border-slate-800 transition-colors duration-300">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400 font-semibold">Edit Buku</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">Perbarui Data Buku</h1>
                    <p class="mt-2 text-slate-600 dark:text-slate-300">Ubah judul atau jumlah halaman untuk buku yang sudah tersimpan</p>
                </div>
                <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 shadow-sm">
                    ID: <span class="font-bold text-slate-900 dark:text-white">{{ $book->id }}</span>
                </div>
            </div>
        </header>

        <!-- Edit Form Section -->
        <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 sm:p-8 shadow-sm dark:shadow-lg">
            <form action="{{ route('book.update', $book->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                @if (session('hasil'))
                    <div class="rounded-lg border border-sky-200 dark:border-sky-900 bg-sky-50 dark:bg-sky-950 px-5 py-4 text-sm text-sky-900 dark:text-sky-100">
                        ✓ {{ session('hasil') }}
                    </div>
                @endif

                <div class="grid gap-6 sm:grid-cols-2">
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Judul Buku</span>
                        <input type="text" name="judul" autocomplete="off" value="{{ $book->judul }}"
                            class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-slate-900 dark:text-white outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100 dark:focus:ring-sky-900"
                            placeholder="Masukkan judul buku" />
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Jumlah Halaman</span>
                        <input type="number" name="jumlah_halaman" autocomplete="off" value="{{ $book->jumlah_halaman }}"
                            class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-slate-900 dark:text-white outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100 dark:focus:ring-sky-900"
                            placeholder="Masukkan jumlah halaman" />
                    </label>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between pt-6 border-t border-slate-200 dark:border-slate-800">
                    <a href="{{ route('book.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 px-6 py-3 text-sm font-semibold text-slate-700 dark:text-slate-300 transition">
                        ← Kembali ke Daftar
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
