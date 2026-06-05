<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Anotasi</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 text-slate-900 min-h-screen">
    <div class="mx-auto max-w-4xl px-6 py-10">
        <header class="mb-10 rounded-3xl bg-white/90 p-8 shadow-lg shadow-slate-200/80 backdrop-blur-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Edit Anotasi</p>
                    <h1 class="mt-2 text-3xl font-semibold text-slate-900">Perbarui Catatan Buku</h1>
                    <p class="mt-2 max-w-2xl text-slate-600">Ubah halaman, catatan, atau tag untuk anotasi yang sudah
                        tersimpan.</p>
                </div>
                <div class="rounded-2xl bg-slate-100 px-4 py-3 text-sm text-slate-700 shadow-inner shadow-slate-200/80">
                    Buku ID: <span class="font-semibold text-slate-900">{{ $annotate->book_id }}</span>
                    <p class="mt-2 text-sm text-slate-700">Total Halaman: <span
                            class="font-semibold text-slate-900">{{ $annotate->book->jumlah_halaman ?? '-' }}</span></p>
                </div>
            </div>
        </header>

        <section class="rounded-3xl bg-white p-8 shadow-lg shadow-slate-200/80">
            <form action="/annotate/{{ $annotate->id }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                @php
                    $inputHalaman = old('halaman', $annotate->halaman);
                    $maxHalaman = $annotate->book->jumlah_halaman ?? null;
                @endphp

                @if (session('hasil'))
                    <div class="rounded-2xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-700">
                        {{ session('hasil') }}
                    </div>
                @endif

                <input type="hidden" name="book_id" value="{{ $annotate->book_id }}">

                <div class="grid gap-6 sm:grid-cols-2">
                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-slate-700">Halaman</span>
                        <p class="mb-2 text-xs text-slate-500">Maksimum halaman buku: {{ $maxHalaman ?? '—' }}</p>
                        <input type="text" name="halaman" autocomplete="off" value="{{ $inputHalaman }}"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100"
                            placeholder="Nomor halaman" />
                        @if ($maxHalaman && $inputHalaman > $maxHalaman)
                            <p class="mt-2 text-sm font-semibold text-rose-700">Halaman tidak valid. Maksimum
                                {{ $maxHalaman }} halaman.</p>
                        @endif
                        @error('halaman')
                            <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                        @enderror
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-slate-700">Tags</span>
                        <input type="text" name="tags" autocomplete="off"
                            value="{{ old('tags', $annotate->tags) }}"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100"
                            placeholder="Pisahkan dengan koma" />
                        @error('tags')
                            <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                        @enderror
                    </label>
                </div>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-700">Catatan</span>
                    <textarea name="catatan" rows="8"
                        class="w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-4 text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100"
                        placeholder="Tuliskan catatan Anda di sini">{{ old('catatan', $annotate->catatan) }}</textarea>
                    @error('catatan')
                        <p class="mt-2 text-sm text-rose-700">{{ $message }}</p>
                    @enderror
                </label>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <a href="/book/{{ $annotate->book_id }}"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">Kembali
                        ke Buku</a>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2 focus:ring-offset-slate-50">Simpan
                        Perubahan</button>
                </div>
            </form>
        </section>
    </div>
</body>

</html>
