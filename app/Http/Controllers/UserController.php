<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Menampilkan form tambah pengguna
    public function create()
    {
        return view('admin.users.create');
    }

    // Menyimpan pengguna baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,panitia,guru,wali_kelas',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil ditambahkan!');
    }

    // Menampilkan form edit pengguna
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Memperbarui data pengguna
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,panitia,guru,wali_kelas',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Jika password diisi, update passwordnya. Jika kosong, biarkan tetap.
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil diperbarui!');
    }

    // Menghapus pengguna
    public function destroy(User $user)
    {
        // Mencegah admin menghapus akunnya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dihapus!');
    }
}
