<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\SchoolClass;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Mendapatkan data dari kolom Excel (header: nisn, name, nama_kelas)
        $nisn = $row['nisn'] ?? null;
        $name = $row['name'] ?? $row['nama'] ?? null;
        $className = $row['nama_kelas'] ?? $row['kelas'] ?? null;

        // Jika data utama kosong, Lewati baris ini
        if (!$nisn || !$name || !$className) {
            return null;
        }

        // Cari ID berdasarkan nama kelas (contoh: '7A')
        $schoolClass = SchoolClass::where('name', trim($className))->first();

        if (!$schoolClass) {
            return null;
        }

        // Simpan atau perbarui data siswa berdasarkan NISN
        return Student::updateOrCreate(
            ['nisn' => trim($nisn)],
            [
                'name' => trim($name),
                'class_id' => $schoolClass->id
            ]
        );
    }
}
