@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Riwayat Peminjaman</h1>
    <p class="text-slate-500 text-sm mt-1">Daftar semua peminjaman alat Anda</p>
</div>

@if($borrowings->count() > 0)
    <div class="space-y-4">
        @foreach($borrowings as $b)
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">

                <div class="flex flex-wrap items-start justify-between gap-4 mb-3">
                    <div>
                        <div class="font-mono text-sm font-semibold text-slate-800">{{ $b->borrowing_code }}</div>
                        <div class="text-xs text-slate-500 mt-1">
                            {{ $b->borrowing_date->format('d M Y') }} — {{ $b->return_date->format('d M Y') }}
                        </div>
                    </div>

                    @php
                        $badge = match($b->status) {
                            'Pending' => 'bg-yellow-100 text-yellow-700',
                            'Approved' => 'bg-green-100 text-green-700',
                            'Rejected' => 'bg-red-100 text-red-700',
                            'Returned' => 'bg-blue-100 text-blue-700',
                        };
                    @endphp
                    <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $badge }}">
                        {{ $b->status }}
                    </span>
                </div>

                <div class="border-t border-slate-100 pt-3">
                    @foreach($b->details as $d)
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-700">{{ $d->tool->name }}</span>
                            <span class="text-slate-500">{{ $d->quantity }} unit</span>
                        </div>
                    @endforeach
                </div>

                <div class="text-xs text-slate-500 mt-3">
                    Tujuan: {{ $b->purpose }}
                </div>

                {{-- 1. MENAMPILKAN INSTRUKSI DARI ADMIN (JIKA SUDAH DI-APPROVE) --}}
                @if($b->status === 'Approved' && $b->admin_note)
                    <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <div class="text-xs font-bold text-green-700 mb-1">Instruksi Admin:</div>
                        <div class="text-sm text-green-600">{{ $b->admin_note }}</div>
                    </div>
                @endif

                {{-- 2. MENAMPILKAN PERINGATAN TERLAMBAT (JIKA MELEWATI BATAS TANGGAL) --}}
                @if($b->status === 'Approved' && \Carbon\Carbon::parse($b->return_date)->isPast())
                    <div class="mt-3 p-3 bg-red-100 border border-red-300 rounded-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <div class="text-sm font-bold text-red-700">
                            ⚠️ TERLAMBAT! Segera kembalikan alat ini.
                        </div>
                    </div>
                @endif

                {{-- 3. MENAMPILKAN ALASAN PENOLAKAN (JIKA DI-REJECT) --}}
                @if($b->status === 'Rejected' && $b->rejection_reason)
                    <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <div class="text-xs font-bold text-red-700 mb-1">Alasan Ditolak Admin:</div>
                        <div class="text-sm text-red-600">{{ $b->rejection_reason }}</div>
                    </div>
                @endif

            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $borrowings->links() }}
    </div>
@else
    <div class="bg-white p-12 rounded-xl text-center text-slate-500 border border-slate-100">
        Belum ada riwayat peminjaman.
    </div>
@endif

@endsection