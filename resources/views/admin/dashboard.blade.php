@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="flex flex-wrap justify-between items-center gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Dashboard Admin</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola peminjaman alat lab komputer</p>
    </div>
    <div class="flex gap-2">
        <a href="/admin/export/pdf"
            class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export PDF
        </a>

        <a href="/admin/export/excel?{{ http_build_query(request()->all()) }}" class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export Excel
        </a>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="text-sm text-slate-500 mb-1">Total Jenis Alat</div>
        <div id="count-tools" class="text-3xl font-bold text-slate-800" data-target="{{ $totalTools }}">0</div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="text-sm text-slate-500 mb-1">Total Stok</div>
        <div id="count-stock" class="text-3xl font-bold text-blue-500" data-target="{{ $totalStock }}">0</div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="text-sm text-slate-500 mb-1">Dipinjam</div>
        <div id="count-borrowed" class="text-3xl font-bold text-green-500" data-target="{{ $borrowedCount }}">0</div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <div class="text-sm text-slate-500 mb-1">Pending</div>
        <div id="count-pending" class="text-3xl font-bold text-yellow-500" data-target="{{ $pendingCount }}">0</div>
    </div>

</div>

{{-- TABEL VERIFIKASI --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">

    <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center">
        <h2 class="font-semibold text-slate-800">Verifikasi Peminjaman</h2>
    </div>

    {{-- PEMBUNGKUS SCROLL HORIZONTAL --}}
    <div class="overflow-x-auto">
        {{-- FORM FILTER --}}
        <form method="GET" action="/admin/dashboard" class="p-5 bg-slate-50 border-b border-slate-100 flex flex-wrap gap-3 items-end min-w-[800px]">
            {{-- ... (kode filter Anda biarkan seperti sebelumnya) ... --}}
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
                <select name="status" class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Returned" {{ request('status') == 'Returned' ? 'selected' : '' }}>Returned</option>
                    <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Dari Tanggal</label>
                <input type="date" name="from" value="{{ request('from') }}" class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1">Sampai Tanggal</label>
                <input type="date" name="to" value="{{ request('to') }}" class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">Filter</button>
            <a href="/admin/dashboard" class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-semibold px-4 py-2 rounded-lg transition">Reset</a>
        </form>

        {{-- TABEL DENGAN MIN-WIDTH AGAR BISA DI-SCROLL KE SAMPING DI HP --}}
        <table class="w-full text-sm min-w-[800px]">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-5 py-3 font-medium">Kode</th>
                    <th class="text-left px-5 py-3 font-medium">Peminjam</th>
                    <th class="text-left px-5 py-3 font-medium">Alat</th>
                    <th class="text-left px-5 py-3 font-medium">Tanggal</th>
                    <th class="text-left px-5 py-3 font-medium">Status</th>
                    <th class="text-right px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($borrowings as $b)
                    <tr>
                        <td class="px-5 py-3 font-mono text-xs">{{ $b->borrowing_code }}</td>
                        <td class="px-5 py-3">
                            <div class="font-medium text-slate-800">{{ $b->user->name }}</div>
                            <div class="text-xs text-slate-500">{{ $b->user->class }}</div>
                        </td>
                        <td class="px-5 py-3">
                            @foreach($b->details as $d)
                                <div>{{ $d->tool->name }} <span class="text-slate-500">({{ $d->quantity }})</span></div>
                            @endforeach
                            {{-- MENAMPILKAN TUJUAN PEMINJAMAN --}}
                            <div class="text-[11px] text-blue-600 mt-1 italic">Tujuan: {{ $b->purpose }}</div>
                        </td>
                        <td class="px-5 py-3 text-xs text-slate-500 whitespace-nowrap">
                            {{ $b->borrowing_date->format('d M Y') }}<br>
                            s/d {{ $b->return_date->format('d M Y') }}
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap">
                            @php
                                $badge = match($b->status) {
                                    'Pending' => 'bg-yellow-100 text-yellow-700',
                                    'Approved' => 'bg-green-100 text-green-700',
                                    'Rejected' => 'bg-red-100 text-red-700',
                                    'Returned' => 'bg-blue-100 text-blue-700',
                                };
                            @endphp
                            <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $badge }}">
                                {{ $b->status }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            @if($b->status === 'Pending')
                                {{-- TOMBOL SETUJUI (MEMICU MODAL APPROVE) --}}
                                <button type="button" onclick="openApproveModal({{ $b->id }})" style="background-color: #22c55e; color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: bold; border: none; cursor: pointer; margin-right: 5px;">
                                    Setujui
                                </button>
                                
                                {{-- TOMBOL TOLAK (MEMICU MODAL REJECT) --}}
                                <button type="button" onclick="openRejectModal({{ $b->id }})" style="background-color: #ef4444; color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: bold; border: none; cursor: pointer;">
                                    Tolak
                                </button>
                            @elseif($b->status === 'Approved')
                                <form method="POST" action="/admin/borrowings/{{ $b->id }}/return" style="display:inline;">
                                    @csrf @method('PUT')
                                    <button type="submit" style="background-color: #3b82f6; color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: bold; border: none; cursor: pointer;">
                                        Kembalikan
                                    </button>
                                </form>
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-slate-400 text-sm">Belum ada data peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-5 py-4 border-t border-slate-100">
        {{ $borrowings->links() }}
    </div>

</div>

{{-- ========================================== --}}
{{-- MODAL APPROVE (POP-UP KETERANGAN) --}}
{{-- ========================================== --}}
<div id="approveModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Setujui Peminjaman</h3>
        <form id="approveForm" method="POST" action="">
            @csrf 
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Keterangan Pengambilan (Opsional)</label>
                <textarea name="admin_note" rows="3" placeholder="Contoh: Silakan ambil alat di TEFA jam istirahat." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeApproveModal()" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-4 py-2 rounded-lg text-sm transition">Batal</button>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">Setujui Peminjaman</button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL REJECT (POP-UP ALASAN PENOLAKAN) --}}
{{-- ========================================== --}}
<div id="rejectModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Tolak Peminjaman</h3>
        <form id="rejectForm" method="POST" action="">
            @csrf 
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Alasan Penolakan</label>
                <textarea name="rejection_reason" rows="3" required placeholder="Contoh: Stok sedang kosong / Alat akan digunakan untuk ujian." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeRejectModal()" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-4 py-2 rounded-lg text-sm transition">Batal</button>
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">Tolak Peminjaman</button>
            </div>
        </form>
    </div>
</div>

{{-- JAVASCRIPT UNTUK MENGATUR MODAL --}}
<script>
    // Script untuk Modal Approve
    function openApproveModal(id) {
        var modal = document.getElementById('approveModal');
        modal.style.display = 'flex'; // Memunculkan modal
        document.getElementById('approveForm').action = '/admin/borrowings/' + id + '/approve';
    }
    function closeApproveModal() {
        document.getElementById('approveModal').style.display = 'none'; // Menyembunyikan
    }

    // Script untuk Modal Reject
    function openRejectModal(id) {
        var modal = document.getElementById('rejectModal');
        modal.style.display = 'flex'; // Memunculkan modal
        document.getElementById('rejectForm').action = '/admin/borrowings/' + id + '/reject';
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none'; // Menyembunyikan
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const counters = document.querySelectorAll('[data-target]');
        const speed = 200; // Semakin kecil, semakin cepat

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