@extends('layouts.app')

@section('title', 'Edit Alat')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">

        <h1 class="text-xl font-bold text-slate-800 mb-6">Edit Alat</h1>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/admin/tools/{{ $tool->id }}" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                <select name="category_id" required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $tool->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Alat</label>
                <input type="text" name="name" value="{{ old('name', $tool->name) }}" required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Spesifikasi</label>
                <textarea name="specification" rows="2"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">{{ old('specification', $tool->specification) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $tool->stock) }}" min="0" required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kondisi</label>
                    <select name="condition" required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        @foreach(['Baik', 'Rusak Ringan', 'Rusak Berat'] as $cond)
                            <option value="{{ $cond }}" {{ old('condition', $tool->condition) == $cond ? 'selected' : '' }}>
                                {{ $cond }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                <select name="status" required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    <option value="Tersedia" {{ old('status', $tool->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Tidak Tersedia" {{ old('status', $tool->status) == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Gambar</label>
                @if($tool->image)
                    <img src="{{ asset('storage/' . $tool->image) }}" class="w-24 h-24 object-cover rounded-lg mb-2">
                @endif
                <input type="file" name="image" accept="image/*"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                <p class="text-xs text-slate-400 mt-1">Kosongkan jika tidak ingin ganti gambar.</p>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-5 py-2 rounded-lg transition">
                    Update
                </button>
                <a href="/admin/tools"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection