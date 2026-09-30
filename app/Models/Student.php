<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nisn',
        'class_id',
        // tambahkan kolom fillable lain jika ada
    ];

    // Relasi ke tabel Kelas (SchoolClass)
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // Relasi ke Nilai (Grades) - INI YANG KURANG SEHINGGA ERROR
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    // Relasi ke Catatan Wali Kelas (StudentNote)
    public function studentNote(): HasOne
    {
        return $this->hasOne(StudentNote::class, 'student_id');
    }
}
