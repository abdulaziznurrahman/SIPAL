@extends('layouts.app')
@section('title', 'Edit Siswa')
@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
        <h1 class="text-xl font-bold text-slate-800 mb-6">Edit Akun Siswa</h1>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <ul class="list-disc list-inside">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <form method="POST" action="/admin/users/{{ $user->id }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">NISN (Username)</label>
                <input type="text" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            @if($user->role === 'siswa')
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kelas</label>
                <input type="text" name="class" value="{{ old('class', $user->class) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru <span class="text-slate-400">(Opsional)</span></label>
                <input type="text" name="password" placeholder="Kosongkan jika tidak ingin ganti password" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            <div class="flex gap-2 pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition">Update Data</button>
                <a href="/admin/users" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2 rounded-lg transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection