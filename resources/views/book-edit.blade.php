<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Buku</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 text-slate-900 min-h-screen">
    <div class="mx-auto max-w-4xl px-6 py-10">
        <header class="mb-10 rounded-3xl bg-white/90 p-8 shadow-lg shadow-slate-200/80 backdrop-blur-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Edit Buku</p>
                    <h1 class="mt-2 text-3xl font-semibold text-slate-900">Perbarui Data Buku</h1>
                    <p class="mt-2 max-w-2xl text-slate-600">Ubah judul atau jumlah halaman untuk buku yang sudah
                        tersimpan.</p>
                </div>
                <div class="rounded-2xl bg-slate-100 px-4 py-3 text-sm text-slate-700 shadow-inner shadow-slate-200/80">
                    Buku ID: <span class="font-semibold text-slate-900">{{ $book->id }}</span>
                </div>
            </div>
        </header>

        <section class="rounded-3xl bg-white p-8 shadow-lg shadow-slate-200/80">
            <form action="{{ route('book.update', $book->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                @if (session('hasil'))
                    <div class="rounded-2xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm text-emerald-700">
                        {{ session('hasil') }}
                    </div>
                @endif

                <div class="grid gap-6 sm:grid-cols-2">
                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-slate-700">Judul Buku</span>
                        <input type="text" name="judul" autocomplete="off" value="{{ $book->judul }}"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100"
                            placeholder="Masukkan judul buku" />
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-medium text-slate-700">Jumlah Halaman</span>
                        <input type="number" name="jumlah_halaman" autocomplete="off"
                            value="{{ $book->jumlah_halaman }}"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100"
                            placeholder="Masukkan jumlah halaman" />
                    </label>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('book.index') }}"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
                        Kembali ke Daftar Buku
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/20 transition hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2 focus:ring-offset-slate-50">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </section>
    </div>
</body>

</html>
