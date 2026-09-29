<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card p-6 rounded-3xl">
                <h1 class="text-2xl font-bold text-teal-400 mb-2">Dashboard Panitia Ujian ASTS</h1>
                <p class="text-slate-300 text-sm">Selamat datang, <b>{{ auth()->user()->name }}</b>. Kelola jadwal, pantau pengumpulan nilai guru, dan lakukan cetak massal rapor sisipan di sini.</p>
            </div>
        </div>
    </div>
</x-app-layout>