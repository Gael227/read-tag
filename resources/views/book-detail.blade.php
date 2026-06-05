<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Detail Buku</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 text-slate-900 min-h-screen">
    <div class="mx-auto max-w-5xl px-6 py-10">
        <header class="mb-8 rounded-3xl bg-white/90 p-8 shadow-lg shadow-slate-200/80 backdrop-blur-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Book Log</p>
                    <h1 class="mt-2 text-3xl font-semibold text-slate-900">Detail Buku</h1>
                    <p class="mt-2 max-w-2xl text-slate-600">Tambah catatan dan lihat annotasi buku secara langsung.</p>
                </div>
                <a href="/book"
                    class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Kembali ke daftar
                </a>
            </div>
        </header>

        @if (session('hasil'))
            <div class="mb-8 rounded-3xl border border-sky-200 bg-sky-50 px-6 py-4 text-slate-900 shadow-sm">
                <p class="font-medium">{{ session('hasil') }}</p>
            </div>
        @endif

        <section class="mb-10 rounded-3xl bg-white p-8 shadow-lg shadow-slate-200/80">
            <div class="grid gap-6 lg:grid-cols-[1fr_260px]">
                <div class="space-y-4">
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Judul</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-900">{{ $book->judul }}</h2>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Total Halaman</p>
                        <p class="mt-2 text-xl font-semibold text-slate-900">{{ $book->jumlah_halaman }}</p>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Tambah Annotasi</p>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">Isi form di bawah untuk menambahkan catatan
                        pada buku ini.</p>
                </div>
            </div>
        </section>

        <section class="mb-10 rounded-3xl bg-white p-8 shadow-lg shadow-slate-200/80">
            <form action="/annotate" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">

                <div class="grid gap-6 sm:grid-cols-3">
                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-slate-700">Halaman</span>
                        <input type="number" name="halaman" autocomplete="off"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100"
                            placeholder="Nomor halaman" />
                    </label>
                    <label class="block sm:col-span-2">
                        <span class="mb-2 block text-sm font-medium text-slate-700">Tags</span>
                        <input type="text" name="tags" autocomplete="off"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100"
                            placeholder="Pisahkan dengan koma" />
                    </label>
                </div>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-700">Catatan</span>
                    <textarea name="catatan" rows="5"
                        class="w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100"
                        placeholder="Tulis catatan Anda"></textarea>
                </label>

                <div>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2 focus:ring-offset-slate-50">
                        Submit
                    </button>
                </div>
            </form>
        </section>

        <section class="rounded-3xl bg-white p-8 shadow-lg shadow-slate-200/80">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Daftar Annotasi</h2>
                    <p class="text-sm text-slate-600">Semua catatan yang tersimpan untuk buku ini.</p>
                </div>
            </div>

            <div class="overflow-x-auto rounded-3xl border border-slate-200">
                <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                    <thead class="bg-slate-100 text-slate-600">
                        <tr>
                            <th class="px-6 py-4 font-medium uppercase tracking-wider">Halaman</th>
                            <th class="px-6 py-4 font-medium uppercase tracking-wider">Catatan</th>
                            <th class="px-6 py-4 font-medium uppercase tracking-wider">Tags</th>
                            <th class="px-6 py-4 font-medium uppercase tracking-wider">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse ($annotates as $a)
                            <tr
                                class="border-t border-slate-200 hover:bg-sky-50/80 {{ $a->halaman > $book->jumlah_halaman ? 'bg-rose-50/60' : '' }}">
                                <td class="px-6 py-4 text-slate-700">
                                    <div class="flex flex-col gap-2">
                                        <span>{{ $a->halaman }}</span>
                                        @if ($a->halaman > $book->jumlah_halaman)
                                            <span
                                                class="inline-flex items-center rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                                Halaman tidak valid
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-900">{{ $a->catatan }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $a->tags }}</td>
                                <td class="px-6 py-4 space-x-3">
                                    <form action="/annotate/{{ $a->id }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus Anotasi Ini?')"
                                            class="rounded-2xl bg-rose-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-rose-700">
                                            Delete
                                        </button>
                                    </form>
                                    <a href="/annotate/{{ $a->id }}/edit"
                                        class="inline-flex rounded-2xl bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-600">Belum ada anotasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>

</html>
