@php
    $isAdmin = Auth::user() && Auth::user()->isAdmin();
    $isCalonSantri = Auth::user() && Auth::user()->role === 'calon_santri';
@endphp

<header class="fixed top-0 left-0 w-full z-40">
    <div class="bg-teal-950/10 border-b border-white/30 px-20 py-6 flex justify-between items-center">

        <!-- Logo -->
        <div class="flex items-center text-white text-xl font-semibold">
            <a href="{{ route('V_Dashboard') }}">
                <img src="{{ asset('assets/ppmq.png') }}" alt="PPMQ Logo" class="h-12">
            </a>
            <h1 class="text-xl font-bold text-emerald-900">SIMQUA</h1>
        </div>

        <!-- Navigation -->
        <div class="flex items-center gap-10">
            @if(isset($isAdmin) && $isAdmin)
                <!-- Menu untuk Admin -->
                <a href="{{ route('admin.pengajuan') }}" class="text-green hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">
                    Pendaftaran
                </a>
            @elseif(isset($isCalonSantri) && $isCalonSantri)
                <!-- Menu untuk Calon Santri -->
                <a href="{{ route('V_Dashboard') }}" class="text-emerald-900 font-bold hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">
                    Home
                </a>

                @if(Route::has('V_Pendaftaran'))
                    <a href="{{ route('V_Pendaftaran') }}" class="text-emerald-900 font-bold hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">
                        Pendaftaran
                    </a>
                @endif

                @if(Route::has('daftarUlang.index'))
                    <a href="{{ route('daftarUlang.index') }}" class="text-emerald-900 font-bold hover:bg-white/10 hover:rounded-lg px-1 hover:border-t hover:border-white">
                        Daftar Ulang
                    </a>
                @endif
            @endif

            <!-- Menu Profil -->
            <a href="{{ route('V_Profil') }}" class="flex items-center gap-3 text-black border border-green-700 bg-white rounded-full px-4 py-1.5 hover:bg-green-700 hover:text-white hover:border-white transition">
                My Profile
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20 22H18V20C18 18.3431 16.6569 17 15 17H9C7.34315 17 6 18.3431 6 20V22H4V20C4 17.2386 6.23858 15 9 15H15C17.7614 15 20 17.2386 20 20V22ZM12 13C8.68629 13 6 10.3137 6 7C6 3.68629 8.68629 1 12 1C15.3137 1 18 3.68629 18 7C18 10.3137 15.3137 13 12 13ZM12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"></path>
                </svg>
            </a>
        </div>
    </div>
</header>
