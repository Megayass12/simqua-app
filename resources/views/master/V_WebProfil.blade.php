@extends('master.V_Public')
@section('title', 'Pondok Pesantren Murottil Quran')
@section('content')

<body class="bg-[#BFDCA0] font-sans">
    <!-- Navbar -->
    <header class="w-full bg-green-500 text-white py-4 shadow-md fixed top-0 z-50">
        <div class="container mx-auto flex justify-between items-center px-6">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('assets/ppmq.png') }}" alt="Logo Pondok" class="h-10">
                <span class="text-xl font-bold">PPMQ Murottil Quran</span>
            </div>
            <nav class="space-x-6">
                <a href="#home" class="hover:underline">Home</a>
                <a href="#visi" class="hover:underline">Visi Misi</a>
                <a href="#program" class="hover:underline">Program</a>
                <a href="{{ route('ppdb') }}" class="hover:underline">PPDB</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex items-center justify-center text-center bg-cover bg-center"
        style="background-image: url('{{ asset('assets/pondok.jpg') }}');">
        <div class="bg-white bg-opacity-80 rounded-lg p-8 shadow-lg max-w-lg">
            <h1 class="text-3xl font-bold text-green-600">خَيْرُكُمْ مَنْ تَعَلَّمَ الْقُرْآنَ وَعَلَّمَهُ</h1>
            <p class="mt-4 text-gray-700">
                Jadilah orang-orang di antara kalian adalah yang terbaik dalam mempelajari Al-Quran dan mengajarkannya.
            </p>
            <p class="mt-2 text-gray-500">PPMQ Murottil Quran, Jember, Jawa Timur</p>
        </div>
    </section>

    <!-- Visi Misi Section -->
    <section id="visi" class="py-16 bg-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-2xl font-bold text-green-600 mb-4">Visi & Misi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-[#BFDCA0] p-6 rounded-lg shadow-md">
                    <h3 class="font-semibold text-lg">Visi</h3>
                    <p class="mt-2 text-gray-600">Mewujudkan generasi Qurani yang berakhlakul karimah.</p>
                </div>
                <div class="bg-green-600 text-white p-6 rounded-lg shadow-md">
                    <h3 class="font-semibold text-lg">Misi</h3>
                    <p class="mt-2">Menghafal Al-Quran, belajar kitab kuning, dan membentuk santri mandiri.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Section -->
    <section id="program" class="py-16 bg-[#BFDCA0]">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-2xl font-bold text-green-600 mb-4">Program Unggulan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-semibold text-lg text-green-600">Tahfidz Quran</h3>
                    <p class="mt-2 text-gray-600">Program hafalan Al-Quran untuk semua santri.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-semibold text-lg text-green-600">Kitab Kuning</h3>
                    <p class="mt-2 text-gray-600">Belajar kitab klasik sebagai bekal keilmuan agama.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="font-semibold text-lg text-green-600">Mandiri</h3>
                    <p class="mt-2 text-gray-600">Membangun kemandirian santri melalui berbagai kegiatan.</p>
                </div>
            </div>
        </div>
    </section>

@include('master.footer')
