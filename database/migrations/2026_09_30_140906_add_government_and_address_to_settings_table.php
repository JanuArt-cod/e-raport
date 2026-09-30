<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Masukkan key default baru ke tabel settings jika belum ada
        DB::table('settings')->insertOrIgnore([
            ['key' => 'government_name', 'value' => 'PEMERINTAH KOTA / DINAS PENDIDIKAN', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'school_address', 'value' => 'Jl. Raya Pendidikan No. 45, Kota Bogor', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', ['government_name', 'school_address'])->delete();
    }
};
