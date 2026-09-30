<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validasi data teks dan file logo (opsional, maks 2MB)
        $request->validate([
            'government_name' => 'required|string|max:255',
            'school_name'     => 'required|string|max:255',
            'school_address'  => 'required|string|max:255',
            'school_city'     => 'required|string|max:100',
            'academic_year'   => 'required|string|max:50',
            'semester'        => 'required|string|max:50',
            'headmaster_name' => 'required|string|max:255',
            'headmaster_nip'  => 'required|string|max:50',
            'school_logo'     => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        // Tangani proses unggah logo baru jika ada
        if ($request->hasFile('school_logo')) {
            // Hapus logo lama jika ada di storage untuk menghemat ruang
            $oldLogo = Setting::get('school_logo');
            if ($oldLogo && Storage::disk('public')->exists(str_replace('storage/', '', $oldLogo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $oldLogo));
            }

            // Simpan file logo baru ke storage/app/public/logos
            $file = $request->file('school_logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('logos', $filename, 'public');

            // Simpan path ke tabel settings
            Setting::updateOrCreate(
                ['key' => 'school_logo'],
                ['value' => 'storage/' . $path]
            );
        }

        // Simpan atau perbarui data teks pengaturan lainnya
        $data = $request->except('_token', '_method', 'school_logo');
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan sistem dan logo sekolah berhasil diperbarui!');
    }
}
