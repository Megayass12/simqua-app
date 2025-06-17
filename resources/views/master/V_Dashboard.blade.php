@extends('master.V_Public')
@section('title', 'Dashboard')
@section('content')

    @auth
        @php
            $isAdmin = Auth::user()->isAdmin();
            $isCalonSantri = Auth::user()->role === 'calon_santri';
        @endphp
    @endauth

    <section class="font-sans min-h-[80vh] bg-cover bg-center py-16 px-6"
        style="background-image: url({{ asset('assets/BG-PD.jpg') }})">

        <!-- Header -->
        @include('master.navbar')

        <!-- Paragraf Berdasarkan Peran -->
        <div class="mb-10 text-center relative z-20">
            @auth
                @if ($isAdmin)
                    <div class="max-w-4xl mx-auto">
                        <!-- Kotak Pembungkus untuk Admin -->
                        <div
                            class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-emerald-200/50 p-8 md:p-12 relative overflow-hidden">
                            <!-- Background Pattern -->
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 via-transparent to-emerald-100/30">
                            </div>
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-emerald-100/20 rounded-full -translate-y-16 translate-x-16">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 w-24 h-24 bg-emerald-200/20 rounded-full translate-y-12 -translate-x-12">
                            </div>

                            <!-- Content -->
                            <div class="relative z-10">
                                <h1
                                    class="text-4xl md:text-5xl lg:text-6xl font-bold bg-gradient-to-r from-emerald-600 via-emerald-700 to-emerald-800 bg-clip-text text-transparent mb-4 leading-tight">
                                    Dashboard Admin
                                </h1>
                                <div
                                    class="w-24 h-1 bg-gradient-to-r from-emerald-500 to-emerald-700 mx-auto mb-6 rounded-full">
                                </div>
                                <p class="text-xl md:text-2xl font-medium text-emerald-800 leading-relaxed px-4">
                                    Selamat datang di pusat kendali administrasi!
                                    <span class="block mt-2 text-lg md:text-xl text-emerald-700">
                                        Kelola informasi, pendaftaran, dan daftar ulang dengan mudah dari sini.
                                    </span>
                                </p>
                                <div class="mt-6 flex justify-center">
                                    <div class="flex space-x-2">
                                        <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                                        <div class="w-3 h-3 bg-emerald-600 rounded-full animate-pulse"
                                            style="animation-delay: 0.2s"></div>
                                        <div class="w-3 h-3 bg-emerald-700 rounded-full animate-pulse"
                                            style="animation-delay: 0.4s"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($isCalonSantri)
                    <div class="max-w-4xl mx-auto">
                        <!-- Kotak Pembungkus untuk Calon Santri -->
                        <div
                            class="bg-white/85 backdrop-blur-lg rounded-3xl shadow-2xl border border-teal-200/50 p-8 md:p-12 relative overflow-hidden">
                            <!-- Background Pattern -->
                            <div class="absolute inset-0 bg-gradient-to-br from-teal-50/40 via-emerald-50/30 to-teal-100/40">
                            </div>
                            <div
                                class="absolute top-0 left-0 w-28 h-28 bg-teal-100/30 rounded-full -translate-y-14 -translate-x-14">
                            </div>
                            <div
                                class="absolute bottom-0 right-0 w-36 h-36 bg-emerald-100/25 rounded-full translate-y-18 translate-x-18">
                            </div>

                            <!-- Content -->
                            <div class="relative z-10">
                                <h1
                                    class="text-4xl md:text-5xl lg:text-6xl font-bold bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-800 bg-clip-text text-transparent mb-4 leading-tight">
                                    Dashboard Calon Santri
                                </h1>
                                <div class="w-32 h-1 bg-gradient-to-r from-teal-500 to-emerald-700 mx-auto mb-6 rounded-full">
                                </div>
                                <p class="text-xl md:text-2xl font-medium text-emerald-800 leading-relaxed px-4">
                                    Selamat datang di perjalanan menuju ilmu yang berkah!
                                    <span class="block mt-2 text-lg md:text-xl text-emerald-700">
                                        Lihat informasi terbaru dan selesaikan pendaftaran Anda dengan mudah.
                                    </span>
                                </p>
                                <div class="mt-6 flex justify-center">
                                    <div
                                        class="bg-emerald-100/70 backdrop-blur-sm rounded-full px-6 py-2 border-2 border-emerald-300/60 shadow-lg">
                                        <span class="text-emerald-800 font-semibold text-sm">📖📿Mari mulai perjalanan belajar
                                            Anda</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="max-w-4xl mx-auto">
                    <!-- Kotak Pembungkus untuk Guest -->
                    <div
                        class="bg-white/75 backdrop-blur-lg rounded-3xl shadow-2xl border border-slate-300/40 p-8 md:p-12 relative overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 bg-gradient-to-br from-slate-50/30 via-emerald-50/20 to-slate-100/40">
                        </div>
                        <div
                            class="absolute top-0 right-0 w-40 h-40 bg-slate-100/20 rounded-full -translate-y-20 translate-x-20">
                        </div>
                        <div
                            class="absolute bottom-0 left-0 w-32 h-32 bg-emerald-100/15 rounded-full translate-y-16 -translate-x-16">
                        </div>

                        <!-- Content -->
                        <div class="relative z-10">
                            <h1
                                class="text-4xl md:text-5xl lg:text-6xl font-bold bg-gradient-to-r from-slate-700 via-emerald-700 to-slate-800 bg-clip-text text-transparent mb-4 leading-tight">
                                Selamat Datang
                            </h1>
                            <div class="w-20 h-1 bg-gradient-to-r from-slate-500 to-emerald-600 mx-auto mb-6 rounded-full">
                            </div>
                            <p class="text-xl md:text-2xl font-medium text-slate-700 leading-relaxed px-4">
                                Masuk untuk mengakses dashboard pribadi Anda
                                <span class="block mt-2 text-lg md:text-xl text-emerald-700">
                                    dan mulai perjalanan pembelajaran yang menakjubkan
                                </span>
                            </p>
                            <div class="mt-8 flex justify-center">
                                <div
                                    class="bg-white/80 backdrop-blur-sm rounded-2xl px-8 py-4 border border-emerald-200/60 shadow-lg">
                                    <span class="text-emerald-800 font-semibold">🔐 Login diperlukan untuk melanjutkan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
        </div>

        <style>
            /* Custom animation untuk loading dots */
            @keyframes pulse-custom {

                0%,
                100% {
                    opacity: 0.4;
                    transform: scale(0.8);
                }

                50% {
                    opacity: 1;
                    transform: scale(1.2);
                }
            }

            .animate-pulse {
                animation: pulse-custom 1.5s ease-in-out infinite;
            }

            /* Hover effects */
            .hover-lift:hover {
                transform: translateY(-2px);
                transition: transform 0.3s ease;
            }

            /* Text shadow untuk readability */
            .text-shadow {
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
        </style>

        <!-- Hero + Cards Container -->
        <div class="flex flex-col items-center justify-center pt-5 px-6">
            <!-- Card Container -->
            <div class="flex flex-wrap justify-center gap-5 mt-10">
                <!-- Card 1 -->
                <a href="{{ route('informasi.index') }}" class="group">
                    <div
                        class="w-72 h-50 bg-white/90 border border-green-700 rounded-lg shadow-lg flex flex-col justify-center items-center p-4 text-center transition-transform duration-300 group-hover:scale-105 hover:shadow-xl">
                        <img src="{{ asset('assets/info.jpg') }}" alt="Informasi" class="h-30 mb-4">
                        <h1 class="text-xl font-bold text-green-700">Informasi</h1>
                    </div>
                </a>

                <!-- Card 2 -->
                <a href="{{ route('V_Pendaftaran') }}" class="group">
                    <div
                        class="w-72 h-50 bg-white/90 border border-blue-700 rounded-lg shadow-lg flex flex-col justify-center items-center p-4 text-center transition-transform duration-300 group-hover:scale-105 hover:shadow-xl">
                        <img src="{{ asset('assets/daftar.jpg') }}" alt="Pendaftaran" class="h-30 mb-4">
                        <h1 class="text-xl font-bold text-blue-700">Pendaftaran</h1>
                    </div>
                </a>

                <!-- Card 3 -->
                <a href="{{ route('daftarUlang.index') }}" class="group">
                    <div
                        class="w-72 h-50 bg-white/90 border border-red-700 rounded-lg shadow-lg flex flex-col justify-center items-center p-4 text-center transition-transform duration-300 group-hover:scale-105 hover:shadow-xl">
                        <img src="{{ asset('assets/daful.jpg') }}" alt="Daftar Ulang" class="h-30 mb-4">
                        <h1 class="text-xl font-bold text-red-700">Daftar Ulang</h1>
                    </div>
                </a>
            </div>
        </div>
    </section>

@endsection
