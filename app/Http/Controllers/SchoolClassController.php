<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    // Menampilkan daftar kelas
    public function index()
    {
        // Mengambil kelas beserta relasi wali kelas dan jumlah siswa di dalamnya
        $classes = SchoolClass::with('homeroomTeacher')->withCount('students')->latest()->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    // Menampilkan form tambah kelas
    public function create()
    {
        // Mengambil user yang memiliki role 'guru' ATAU 'wali_kelas'
        $teachers = User::whereIn('role', ['guru', 'wali_kelas'])->get();
        return view('admin.classes.create', compact('teachers'));
    }

    // Menyimpan kelas baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:classes',
            'homeroom_teacher_id' => 'nullable|exists:users,id',
        ]);

        SchoolClass::create([
            'name' => $request->name,
            'homeroom_teacher_id' => $request->homeroom_teacher_id,
        ]);

        return redirect()->route('admin.classes.index')->with('success', 'Data rombel kelas berhasil ditambahkan!');
    }

    // Menampilkan form edit kelas
    public function edit(SchoolClass $class)
    {
        // Mengambil user yang memiliki role 'guru' ATAU 'wali_kelas'
        $teachers = User::whereIn('role', ['guru', 'wali_kelas'])->get();
        return view('admin.classes.edit', compact('class', 'teachers'));
    }

    // Memperbarui data kelas
    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:classes,name,' . $class->id,
            'homeroom_teacher_id' => 'nullable|exists:users,id',
        ]);

        $class->update([
            'name' => $request->name,
            'homeroom_teacher_id' => $request->homeroom_teacher_id,
        ]);

        return redirect()->route('admin.classes.index')->with('success', 'Data rombel kelas berhasil diperbarui!');
    }

    // Menghapus kelas
    public function destroy(SchoolClass $class)
    {
        $class->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Data rombel kelas berhasil dihapus!');
    }
}