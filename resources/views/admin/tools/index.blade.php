@extends('layouts.app')

@section('title', 'Kelola Alat')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Kelola Alat</h1>
        <p class="text-slate-500 text-sm mt-1">Daftar alat lab komputer</p>
    </div>
    <a href="/admin/tools/create"
        class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
        + Tambah Alat
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-5 py-3 font-medium">Gambar</th>
                    <th class="text-left px-5 py-3 font-medium">Nama</th>
                    <th class="text-left px-5 py-3 font-medium">Kategori</th>
                    <th class="text-center px-5 py-3 font-medium">Stok</th>
                    <th class="text-left px-5 py-3 font-medium">Kondisi</th>
                    <th class="text-left px-5 py-3 font-medium">Status</th>
                    <th class="text-right px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($tools as $tool)
                    <tr>
                        <td class="px-5 py-3">
                            @if($tool->image)
                                <img src="{{ asset('storage/' . $tool->image) }}" class="w-12 h-12 object-cover rounded-lg">
                            @else
                                <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 text-xs">No Img</div>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="font-medium text-slate-800">{{ $tool->name }}</div>
                            <div class="text-xs text-slate-500">{{ $tool->specification }}</div>
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $tool->category->name }}</td>
                        <td class="px-5 py-3 text-center font-semibold">{{ $tool->stock }}</td>
                        <td class="px-5 py-3 text-slate-600 text-xs">{{ $tool->condition }}</td>
                        <td class="px-5 py-3">
                            @if($tool->status === 'Tersedia')
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Tersedia</span>
                            @else
                                <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full">Tidak Tersedia</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex justify-end gap-1">
                                <a href="/admin/tools/{{ $tool->id }}/edit"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-3 py-1.5 rounded-lg transition">
                                    Edit
                                </a>
                                <form method="POST" action="/admin/tools/{{ $tool->id }}"
                                    onsubmit="return confirm('Hapus alat ini?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1.5 rounded-lg transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-slate-400">Belum ada alat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-5 py-4 border-t border-slate-100">
        {{ $tools->links() }}
    </div>
</div>

@endsection