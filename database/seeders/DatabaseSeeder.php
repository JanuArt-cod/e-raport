<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\TeacherSubject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Users dengan Role Khusus
        $admin = User::create([
            'name' => 'Administrator Sekolah',
            'email' => 'admin@tes.id',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        $panitia = User::create([
            'name' => 'Panitia Ujian ASTS',
            'email' => 'panitia@tes.id',
            'password' => Hash::make('admin'),
            'role' => 'panitia',
        ]);

        $guru1 = User::create([
            'name' => 'Budi Santoso, S.Pd.',
            'email' => 'budi@tes.id',
            'password' => Hash::make('admin'),
            'role' => 'guru',
        ]);

        $guru2 = User::create([
            'name' => 'Siti Aminah, M.Pd.',
            'email' => 'siti@tes.id',
            'password' => Hash::make('admin'),
            'role' => 'guru',
        ]);

        // 2. Buat Data Mata Pelajaran
        $matematika = Subject::create(['name' => 'Matematika']);
        $bindo = Subject::create(['name' => 'Bahasa Indonesia']);
        $ipa = Subject::create(['name' => 'Ilmu Pengetahuan Alam (IPA)']);

        // 3. Buat Data Kelas & Wali Kelas
        $kelas7A = SchoolClass::create([
            'name' => '7A',
            'homeroom_teacher_id' => $guru1->id, // Wali kelas 7A: Pak Budi
        ]);

        $kelas7B = SchoolClass::create([
            'name' => '7B',
            'homeroom_teacher_id' => $guru2->id, // Wali kelas 7B: Bu Siti
        ]);

        // 4. Buat Data Siswa
        $students7A = [
            ['nisn' => '2026001', 'name' => 'Ahmad Fauzi', 'class_id' => $kelas7A->id],
            ['nisn' => '2026002', 'name' => 'Dewi Lestari', 'class_id' => $kelas7A->id],
            ['nisn' => '2026003', 'name' => 'Rizky Pratama', 'class_id' => $kelas7A->id],
        ];

        $students7B = [
            ['nisn' => '2026004', 'name' => 'Siti Nurhaliza', 'class_id' => $kelas7B->id],
            ['nisn' => '2026005', 'name' => 'Eko Prasetyo', 'class_id' => $kelas7B->id],
        ];

        foreach (array_merge($students7A, $students7B) as $studentData) {
            Student::create($studentData);
        }

        // 5. Mapping Pengajar (Teacher Subjects)
        TeacherSubject::create(['teacher_id' => $guru1->id, 'subject_id' => $matematika->id, 'class_id' => $kelas7A->id]);
        TeacherSubject::create(['teacher_id' => $guru1->id, 'subject_id' => $matematika->id, 'class_id' => $kelas7B->id]);
        TeacherSubject::create(['teacher_id' => $guru2->id, 'subject_id' => $bindo->id, 'class_id' => $kelas7A->id]);
    }
}
