@extends('layouts.app')
@section('title', 'Tambah Pengguna')
@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
        <h1 class="text-xl font-bold text-slate-800 mb-6">Tambah Akun Pengguna</h1>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <ul class="list-disc list-inside">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <form method="POST" action="/admin/users" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">NISN (Sebagai Username)</label>
                <input type="text" name="email" value="{{ old('email') }}" required placeholder="Contoh: 1004" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kelas</label>
                <input type="text" name="class" value="{{ old('class') }}" required placeholder="Contoh: XII RPL 1" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="text" name="password" required placeholder="Minimal 6 karakter" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div class="flex gap-2 pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition">Simpan</button>
                <a href="/admin/users" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2 rounded-lg transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection