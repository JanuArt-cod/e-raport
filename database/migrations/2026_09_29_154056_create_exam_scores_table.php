<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exam_scores', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel students
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            // Relasi ke tabel subjects
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            // Nilai angka ujian (contoh: 85.50)
            $table->decimal('score', 5, 2);
            // ID Guru yang menginput/memperbarui nilai (mengarah ke tabel users)
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_scores');
    }
};
