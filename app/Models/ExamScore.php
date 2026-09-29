<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'score',
        'updated_by',
    ];

    /**
     * Relasi ke Siswa pemilik nilai
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Relasi ke Mata Pelajaran
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Relasi ke Guru yang menginput nilai
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
