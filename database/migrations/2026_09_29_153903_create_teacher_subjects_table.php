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
        Schema::create('teacher_subjects', function (Blueprint $table) {
            $table->id();
            // Mengarah ke tabel users (karena akun guru ada di tabel users)
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            // Mengarah ke tabel subjects
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            // Mengarah ke tabel classes
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_subjects');
    }
};
