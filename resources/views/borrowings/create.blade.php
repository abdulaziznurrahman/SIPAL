@extends('layouts.app')

@section('title', 'Form Peminjaman')

@section('content')

<div class="mb-4">
    <a href="/katalog/{{ $tool->id }}" class="text-sm text-blue-500 hover:text-blue-600">&larr; Kembali ke Detail Alat</a>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">

        <h1 class="text-2xl font-bold text-slate-800 mb-1">Form Peminjaman Alat</h1>
        <p class="text-slate-500 text-sm mb-6">Isi data peminjaman dengan lengkap</p>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/pinjam" class="space-y-4">
            @csrf
            <input type="hidden" name="tool_id" value="{{ $tool->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Peminjam</label>
                    <input type="text" value="{{ auth()->user()->name }}" readonly
                        class="w-full px-4 py-2 bg-slate-100 border border-slate-300 rounded-lg text-slate-600 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kelas</label>
                    <input type="text" value="{{ auth()->user()->class }}" readonly
                        class="w-full px-4 py-2 bg-slate-100 border border-slate-300 rounded-lg text-slate-600 text-sm">
                </div>

            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Alat</label>
                <input type="text" value="{{ $tool->name }}" readonly
                    class="w-full px-4 py-2 bg-slate-100 border border-slate-300 rounded-lg text-slate-600 text-sm">
                <p class="text-xs text-slate-500 mt-1">Stok tersedia: {{ $tool->stock }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Pinjam</label>
                <input type="number" name="quantity" value="1" readonly
                    class="w-full px-4 py-2 bg-slate-100 border border-slate-300 rounded-lg text-slate-500 text-sm cursor-not-allowed">
                <p class="text-xs text-slate-400 mt-1">Sistem membatasi peminjaman hanya 1 unit per alat.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Pinjam</label>
                    <input type="date" name="borrowing_date" value="{{ old('borrowing_date', date('Y-m-d')) }}" required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Kembali</label>
                    <input type="date" name="return_date" value="{{ old('return_date', date('Y-m-d', strtotime('+3 days'))) }}" required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tujuan Peminjaman</label>
                <textarea name="purpose" rows="3" required
                    placeholder="Contoh: Untuk praktikum jaringan di lab"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">{{ old('purpose') }}</textarea>
            </div>

            {{-- TOMBOL DENGAN ANIMASI LOADING SPINNER --}}
            <button type="submit" 
                onclick="this.disabled=true; this.innerHTML='<svg class=\'animate-spin h-5 w-5 mr-3 border-2 border-white border-t-transparent rounded-full inline-block\' viewBox=\'0 0 24 24\'></svg> Memproses...'; this.form.submit();"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow-lg shadow-blue-500/50 hover:shadow-blue-500/80 hover:-translate-y-0.5 transition-all duration-300 flex justify-center items-center gap-2">
                Ajukan Peminjaman
            </button>

        </form>
    </div>
</div>

@endsection