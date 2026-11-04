<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Tampilkan Siswa DAN Guru
        $users = User::whereIn('role', ['siswa', 'guru'])->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

        public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:50|unique:users,email', 
            'class' => 'required|string|max:50',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'class' => $request->class,
            'password' => Hash::make($request->password),
            'role' => 'siswa', // Paksa jadi siswa
        ]);

        return redirect('/admin/users')->with('success', 'Akun Siswa berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:50|unique:users,email,' . $user->id,
            'class' => 'nullable|string|max:50',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'class' => $user->role === 'guru' ? 'Guru Pengampu' : $request->class,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect('/admin/users')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Akun berhasil dihapus.');
    }
}