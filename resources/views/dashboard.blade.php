@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- ========================================== --}}
{{-- NOTIFIKASI KETERLAMBATAN (OVERDUE) --}}
{{-- ========================================== --}}
@php
    $overdueBorrowings = $recent->filter(function($b) {
        return $b->status === 'Approved' && \Carbon\Carbon::parse($b->return_date)->isPast();
    });
@endphp

@if($overdueBorrowings->count() > 0)
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg shadow-sm flex items-start gap-3">
        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <div>
            <h3 class="font-bold text-lg">Peringatan Keterlambatan!</h3>
            <p class="text-sm mt-1">Anda memiliki alat yang <strong>melewati batas waktu pengembalian</strong>. Harap segera kembalikan alat tersebut ke Lab/TEFA agar tidak dikenakan sanksi.</p>
        </div>
    </div>
@endif

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Halo, {{ auth()->user()->name }} 👋</h1>
    <p class="text-slate-500 text-sm mt-1">Ringkasan peminjaman Anda</p>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="text-sm text-slate-500 mb-1">Total Peminjaman</div>
        <div id="count-total" class="text-3xl font-bold text-slate-800" data-target="{{ $totalBorrowings }}">0</div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="text-sm text-slate-500 mb-1">Pending</div>
        <div id="count-pending" class="text-3xl font-bold text-yellow-500" data-target="{{ $pending }}">0</div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="text-sm text-slate-500 mb-1">Disetujui</div>
        <div id="count-approved" class="text-3xl font-bold text-green-500" data-target="{{ $approved }}">0</div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="text-sm text-slate-500 mb-1">Dikembalikan</div>
        <div id="count-returned" class="text-3xl font-bold text-blue-500" data-target="{{ $returned }}">0</div>
    </div>

</div>

{{-- AKSI CEPAT --}}
<div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mb-8">
    <h2 class="font-semibold text-slate-800 mb-3">Aksi Cepat</h2>
    <div class="flex flex-wrap gap-3">
        <a href="/katalog" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
            Lihat Katalog Alat
        </a>
        <a href="/riwayat" class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 text-sm font-semibold px-4 py-2 rounded-lg transition">
            Riwayat Peminjaman
        </a>
    </div>
</div>

{{-- PEMINJAMAN TERBARU --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100">
        <h2 class="font-semibold text-slate-800">Peminjaman Terbaru</h2>
    </div>

    <div class="divide-y divide-slate-100">
        @forelse($recent as $b)
            <div class="px-5 py-4 flex justify-between items-center">
                <div>
                    <div class="font-mono text-xs text-slate-500">{{ $b->borrowing_code }}</div>
                    <div class="text-sm font-medium text-slate-800 mt-1">
                        @foreach($b->details as $d)
                            {{ $d->tool->name }} ({{ $d->quantity }}x)
                        @endforeach
                    </div>

                    {{-- MENAMPILKAN KETERANGAN DARI ADMIN --}}
                    @if($b->admin_note && $b->status === 'Approved')
                        <div class="text-xs text-green-700 mt-1 bg-green-50 p-1.5 rounded inline-block border border-green-100">
                            <strong>Pesan Admin:</strong> {{ $b->admin_note }}
                        </div>
                    @endif
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
        @empty
            <div class="px-5 py-8 text-center text-slate-400 text-sm">
                Belum ada peminjaman. <a href="/katalog" class="text-blue-500 hover:underline">Mulai pinjam alat</a>
            </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const counters = document.querySelectorAll('[data-target]');
        const speed = 200; 

        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 15);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    });
</script>
@endsection