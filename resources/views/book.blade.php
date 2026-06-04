<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book Log</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 text-slate-900 min-h-screen">
    <div class="mx-auto max-w-5xl px-6 py-10">
        <header class="mb-10 rounded-3xl bg-white/90 p-8 shadow-lg shadow-slate-200/80 backdrop-blur-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Book Log</p>
                    <h1 class="mt-2 text-3xl font-semibold text-slate-900">Form Input Buku</h1>
                    <p class="mt-2 max-w-2xl text-slate-600">Tambahkan buku baru dan lihat daftar yang sudah tersimpan.
                    </p>
                </div>
                <div class="rounded-2xl bg-slate-100 px-4 py-3 text-sm text-slate-700 shadow-inner shadow-slate-200/80">
                    Total buku: <span class="font-semibold text-slate-900">{{ $book->count() }}</span>
                </div>
                <form action="{{ route('search.annotate') }}" method="GET" class="flex gap-2">
                    <input type="text" name="q" placeholder="Cari halaman/tags..."
                        class="rounded-2xl border border-slate-300 bg-slate-50 px-4 py-2 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100" />
                    <button type="submit"
                        class="rounded-2xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-sky-700">
                        Cari
                    </button>
                </form>
            </div>
        </header>

        <section class="mb-10 rounded-3xl bg-white p-8 shadow-lg shadow-slate-200/80">
            <form action="/book" method="POST" class="space-y-6">
                @csrf
                <div class="grid gap-6 sm:grid-cols-2">
                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-slate-700">Judul</span>
                        <input type="text" name="judul"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100"
                            placeholder="Masukkan judul buku" />
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-slate-700">Total Halaman</span>
                        <input type="text" name="jumlah_halaman"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100"
                            placeholder="Jumlah halaman" />
                    </label>
                </div>

                <div>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2 focus:ring-offset-slate-50">
                        Submit
                    </button>
                </div>
            </form>
        </section>

        @if (isset($searched) && $searched)
            <!-- Tabel Hasil Pencarian -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Hasil Pencarian</h2>
                </div>
                <a href="/book"
                    class="rounded-2xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                    Tampilkan Semua Buku
                </a>
            </div>

            <div class="overflow-x-auto rounded-3xl border border-slate-200">
                <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                    <thead class="bg-slate-100 text-slate-600">
                        <tr>
                            <th class="px-6 py-4 font-medium uppercase tracking-wider">Halaman</th>
                            <th class="px-6 py-4 font-medium uppercase tracking-wider">Catatan</th>
                            <th class="px-6 py-4 font-medium uppercase tracking-wider">Tags</th>
                            <th class="px-6 py-4 font-medium uppercase tracking-wider">Dari Buku</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($annotates as $a)
                            <tr class="border-t border-slate-200 hover:bg-sky-50/80">
                                <td class="px-6 py-4 text-slate-700">{{ $a->halaman }}</td>
                                <td class="px-6 py-4 text-slate-900">{{ Str::limit($a->catatan, 50) }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $a->tags }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $a->book->judul }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-600">Tidak ada hasil
                                    ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <section class="rounded-3xl bg-white p-6 shadow-lg shadow-slate-200/80">
                <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">Daftar Buku</h2>
                        <p class="text-sm text-slate-600">Klik judul untuk melihat detail buku.</p>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-3xl border border-slate-200">
                    <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                        <thead class="bg-slate-100 text-slate-600">
                            <tr>
                                <th class="px-6 py-4 font-medium uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-4 font-medium uppercase tracking-wider">Total Halaman</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($book as $b)
                                <tr class="border-t border-slate-200 hover:bg-sky-50/80">
                                    <td class="px-6 py-4">
                                        <a href="/book/{{ $b->id }}"
                                            class="font-medium text-slate-900 transition hover:text-sky-600">{{ $b->judul }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-slate-700">{{ $b->jumlah_halaman }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </div>
</body>

</html>
</body>

</html>
