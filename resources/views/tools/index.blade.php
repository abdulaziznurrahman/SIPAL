@extends('layouts.app')

@section('title', 'Katalog Alat')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Katalog Alat Lab</h1>
    <p class="text-slate-500 text-sm mt-1">Pilih alat yang ingin Anda pinjam</p>
</div>

{{-- FILTER BAR --}}
<form method="GET" action="/katalog" class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama alat..."
            class="md:col-span-2 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">

        <select name="category_id"
            class="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <select name="status"
            class="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            <option value="">Semua Status</option>
            <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="Tidak Tersedia" {{ request('status') == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
        </select>

    </div>
    <div class="mt-3 flex gap-2">
        <button type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
            Filter
        </button>
        <a href="/katalog"
            class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold px-4 py-2 rounded-lg transition">
            Reset
        </a>
    </div>
</form>

{{-- GRID ALAT --}}
@if($tools->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($tools as $tool)
            {{-- CLASS GROUP DAN HOVER DITAMBAHKAN DI SINI --}}
            <div class="group bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">

                {{-- Gambar --}}
                <div class="h-40 bg-slate-100 flex items-center justify-center overflow-hidden">
                    @if($tool->image)
                        {{-- CLASS TRANSFORM ZOOM DITAMBAHKAN DI SINI --}}
                        <img src="{{ asset('storage/' . $tool->image) }}" alt="{{ $tool->name }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <svg class="w-16 h-16 text-slate-300 transition-transform duration-500 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    @endif
                </div>

                {{-- Isi --}}
                <div class="p-4">
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <h3 class="font-semibold text-slate-800 group-hover:text-blue-600 transition-colors">{{ $tool->name }}</h3>
                        @if($tool->status === 'Tersedia')
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full whitespace-nowrap">Tersedia</span>
                        @else
                            <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full whitespace-nowrap">Tidak Tersedia</span>
                        @endif
                    </div>

                    <p class="text-xs text-slate-500 mb-3">{{ $tool->category->name }}</p>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-slate-600">Stok: <span class="font-semibold text-slate-800">{{ $tool->stock }}</span></span>
                        <span class="text-xs text-slate-500">{{ $tool->condition }}</span>
                    </div>

                    {{-- TOMBOL GLOW MENYALA (LANGKAH 2) --}}
                    <a href="/katalog/{{ $tool->id }}"
                        style="transition: all 0.3s ease;"
                        onmouseover="this.style.boxShadow='0 10px 15px -3px rgba(59, 130, 246, 0.5)'; this.style.transform='translateY(-2px)';" 
                        onmouseout="this.style.boxShadow='none'; this.style.transform='translateY(0)';"
                        class="block text-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 rounded-lg">
                        Lihat Detail
                    </a>
                </div>

            </div>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $tools->links() }}
    </div>
@else
    <div class="bg-white p-12 rounded-xl text-center text-slate-500 border border-slate-100">
        Tidak ada alat yang cocok dengan filter Anda.
    </div>
@endif

@endsection