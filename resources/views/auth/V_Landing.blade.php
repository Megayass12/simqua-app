@extends('master.V_Public')
@section('title', 'Homepage')
@section('content')

<section class="font-sans h-screen bg-cover bg-center relative">
    <!-- Background Blur -->
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image: url({{ asset('assets/BG-PD.jpg') }}); filter: blur(5px);">
    </div>

    <!-- Hero Section -->
    <div class="relative h-screen flex flex-col items-center justify-center text-center px-4 z-10">
        <!-- Kotak Pembungkus -->
        <div class="bg-green-100 w-2/3 h-2/3 bg-opacity-90 border border-gray-300 rounded-lg shadow-lg flex flex-col justify-center items-center gap-8 p-8">
            <!-- Teks Besar SIMQUA -->
            <h1 class="text-6xl font-bold text-emerald-900">SIMQUA</h1>
            <h2 class="text-xl text-emerald-700">Sistem Informasi Murottilil Qur'an</h2>
            <!-- Tombol Sejajar -->
            <div class="flex gap-4">
                <!-- Tombol Masuk -->
                <a href="login"
                   class="flex items-center gap-1 text-black border border-emerald-900 rounded-full px-4 py-1.5 hover:bg-white hover:text-black transition">
                    Masuk
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <!-- Tombol Daftar -->
                <a href="register"
                   class="bg-white border-emerald-900 text-black font-semibold px-4 py-1.5 rounded-full hover:bg-emerald-900 transition">
                    Daftar Sekarang!
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
