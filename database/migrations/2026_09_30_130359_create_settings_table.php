<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Masukkan data default awal (Seed data)
        DB::table('settings')->insert([
            ['key' => 'school_name', 'value' => 'SMP / M.Ts Negeri E-Rapor ASTS', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'school_city', 'value' => 'Bogor', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'academic_year', 'value' => '2025/2026', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'semester', 'value' => 'Ganjil', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'headmaster_name', 'value' => 'Dr. H. Ahmad Fauzi, M.Pd.', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'headmaster_nip', 'value' => '197505122000031005', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
