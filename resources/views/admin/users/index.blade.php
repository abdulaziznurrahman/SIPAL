@extends('layouts.app')
@section('title', 'Kelola Pengguna')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Kelola Pengguna</h1>
        <p class="text-slate-500 text-sm mt-1">Daftar akun Siswa dan Guru yang terdaftar</p>
    </div>
    <a href="/admin/users/create" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition shadow-md">
        + Tambah Pengguna
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[600px]">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-5 py-3 font-medium">NISN / NIP</th>
                    <th class="text-left px-5 py-3 font-medium">Nama Lengkap</th>
                    <th class="text-left px-5 py-3 font-medium">Kelas / Role</th>
                    <th class="text-right px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                    <tr>
                        <td class="px-5 py-3 font-mono text-xs">{{ $user->email }}</td>
                        <td class="px-5 py-3 font-medium text-slate-800">
                            {{ $user->name }}
                            {{-- LABEL GURU --}}
                            @if($user->role === 'guru')
                                <span class="ml-2 text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Guru</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-slate-600">
                            @if($user->role === 'guru')
                                Guru Pengampu
                            @else
                                {{ $user->class }}
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="/admin/users/{{ $user->id }}/edit" class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-3 py-1.5 rounded-lg transition">Edit</a>
                                <form method="POST" action="/admin/users/{{ $user->id }}" onsubmit="return confirm('Hapus akun pengguna ini?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1.5 rounded-lg transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-slate-400">Belum ada data pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $users->links() }}
    </div>
</div>
@endsection