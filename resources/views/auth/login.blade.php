<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- BAGIAN LOGO & NAMA SEKOLAH DI DALAM CARD LOGIN -->
    <div class="text-center mb-6">
        @if(\App\Models\Setting::get('school_logo'))
                        <img src="{{ asset(\App\Models\Setting::get('school_logo')) }}" alt="Logo Sekolah" class="w-16 h-16 object-contain mx-auto">
                    @else
                        <div class="w-16 h-16 border border-dashed border-slate-400 flex items-center justify-center text-[9px] text-slate-400 mx-auto">Logo</div>
                    @endif

        <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-1">
            {{ config('school.name', 'Masuk ke Sistem') }}
        </h2>
        <p class="text-xs text-slate-500 dark:text-slate-400">Silakan masukkan kredensial akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="fa-solid fa-envelope mr-1 text-emerald-600 dark:text-emerald-400"></i> Email
            </label>
            <x-text-input id="email" class="block mt-1 w-full glass-input rounded-xl px-4 py-3 text-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@sekolah.sch.id" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-rose-500 dark:text-rose-400" />
        </div>

        <!-- Password -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                <i class="fa-solid fa-lock mr-1 text-emerald-600 dark:text-emerald-400"></i> Kata Sandi
            </label>
            <x-text-input id="password" class="block mt-1 w-full glass-input rounded-xl px-4 py-3 text-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" 
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-rose-500 dark:text-rose-400" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between text-xs text-slate-600 dark:text-slate-400">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-emerald-600 shadow-sm focus:ring-0" name="remember">
                <span class="ms-2">Ingat saya</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-3.5 px-4 rounded-xl font-bold text-sm bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white shadow-lg shadow-emerald-600/25 transition-all duration-300 transform active:scale-95 flex items-center justify-center space-x-2">
                <span>Masuk ke Sistem</span>
                <i class="fa-solid fa-arrow-right-long"></i>
            </button>
        </div>
    </form>
</x-guest-layout>