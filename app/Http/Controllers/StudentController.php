<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport; // Nanti kita buat file import ini

class StudentController extends Controller
{
    // Menampilkan daftar siswa dengan fitur pencarian & filter kelas
    public function index(Request $request)
    {
        $query = Student::with('schoolClass');

        // Fitur Filter Berdasarkan Kelas
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Fitur Pencarian Nama atau NISN
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $students = $query->latest()->paginate(10)->withQueryString();
        $classes = SchoolClass::all();

        return view('admin.students.index', compact('students', 'classes'));
    }

    // Form Tambah Siswa
    public function create()
    {
        $classes = SchoolClass::all();
        return view('admin.students.create', compact('classes'));
    }

    // Simpan Siswa Baru
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|max:20|unique:students,nisn',
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
        ]);

        Student::create($request->all());

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    // Form Edit Siswa
    public function edit(Student $student)
    {
        $classes = SchoolClass::all();
        return view('admin.students.edit', compact('student', 'classes'));
    }

    // Update Siswa
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nisn' => 'required|string|max:20|unique:students,nisn,' . $student->id,
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
        ]);

        $student->update($request->all());

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    // Hapus Siswa
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil dihapus!');
    }

    // 1. Fitur Unduh Template Excel
    public function downloadTemplate()
    {
        $fileName = "template_import_siswa.csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            // Header kolom template
            fputcsv($file, ['nisn', 'name', 'nama_kelas']);
            // Contoh baris data panduan
            fputcsv($file, ['2026001', 'Ahmad Fauzi', '7A']);
            fputcsv($file, ['2026002', 'Dewi Lestari', '7A']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // 2. Fitur Proses Upload / Import Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv,txt|max:2048',
        ]);

        try {
            // Memproses file menggunakan Laravel Excel
            Excel::import(new StudentsImport, $request->file('file'));

            return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diimpor!');
        } catch (\Exception $e) {
            return redirect()->route('admin.students.index')->with('error', 'Gagal mengimpor file: ' . $e->getMessage());
        }
    }
}
