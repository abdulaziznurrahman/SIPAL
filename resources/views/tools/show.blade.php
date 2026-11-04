@extends('layouts.app')

@section('title', $tool->name)

@section('content')

<div class="mb-4">
    <a href="/katalog" class="text-sm text-blue-500 hover:text-blue-600">&larr; Kembali ke Katalog</a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- FOTO --}}
        <div class="bg-slate-100 rounded-xl flex items-center justify-center h-80">
            @if($tool->image)
                <img src="{{ asset('storage/' . $tool->image) }}" alt="{{ $tool->name }}"
                    class="w-full h-full object-cover rounded-xl">
            @else
                <svg class="w-32 h-32 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            @endif
        </div>

        {{-- DETAIL --}}
        <div>
            <div class="flex items-start justify-between gap-4 mb-3">
                <h1 class="text-2xl font-bold text-slate-800">{{ $tool->name }}</h1>
                @if($tool->status === 'Tersedia')
                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full whitespace-nowrap">Tersedia</span>
                @else
                    <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full whitespace-nowrap">Tidak Tersedia</span>
                @endif
            </div>

            <p class="text-sm text-slate-500 mb-6">{{ $tool->category->name }}</p>

            <div class="space-y-3 text-sm mb-6">
                <div class="flex justify-between border-b border-slate-100 pb-2">
                    <span class="text-slate-500">Stok Tersedia</span>
                    <span class="font-semibold text-slate-800">{{ $tool->stock }}</span>
                </div>
                <div class="flex justify-between border-b border-slate-100 pb-2">
                    <span class="text-slate-500">Kondisi</span>
                    <span class="font-semibold text-slate-800">{{ $tool->condition }}</span>
                </div>
                <div class="border-b border-slate-100 pb-2">
                    <span class="text-slate-500 block mb-1">Spesifikasi</span>
                    <span class="text-slate-800">{{ $tool->specification ?? '-' }}</span>
                </div>
            </div>

            @if($tool->status === 'Tersedia' && $tool->stock > 0)
                <a href="/pinjam/{{ $tool->id }}"
                    class="block text-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition">
                    Ajukan Peminjaman
                </a>
            @else
                <button disabled
                    class="block w-full text-center bg-slate-300 text-slate-500 font-semibold py-3 rounded-lg cursor-not-allowed">
                    Alat Tidak Tersedia
                </button>
            @endif
        </div>

    </div>
</div>

@endsection