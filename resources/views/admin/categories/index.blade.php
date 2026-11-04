@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Kelola Kategori</h1>
        <p class="text-slate-500 text-sm mt-1">Daftar kategori alat lab</p>
    </div>
    <a href="/admin/categories/create"
        class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
        + Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
            <tr>
                <th class="text-left px-5 py-3 font-medium">Nama</th>
                <th class="text-left px-5 py-3 font-medium">Deskripsi</th>
                <th class="text-center px-5 py-3 font-medium">Jumlah Alat</th>
                <th class="text-right px-5 py-3 font-medium">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($categories as $cat)
                <tr>
                    <td class="px-5 py-3 font-medium text-slate-800">{{ $cat->name }}</td>
                    <td class="px-5 py-3 text-slate-600">{{ $cat->description ?? '-' }}</td>
                    <td class="px-5 py-3 text-center">
                        <span class="text-xs bg-slate-100 px-2 py-1 rounded-full">{{ $cat->tools_count }}</span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="/admin/categories/{{ $cat->id }}/edit"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-3 py-1.5 rounded-lg transition">
                                Edit
                            </a>
                            <form method="POST" action="/admin/categories/{{ $cat->id }}"
                                onsubmit="return confirm('Hapus kategori ini?')">
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
                    <td colspan="4" class="text-center py-8 text-slate-400">Belum ada kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-5 py-4 border-t border-slate-100">
        {{ $categories->links() }}
    </div>
</div>

@endsection