@extends('master.V_Public')
@section('title', 'Pondok Pesantren Murottil Quran')
@section('content')

    <style>
        /* Custom animations and enhanced styling */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }

        .animate-slideInLeft {
            animation: slideInLeft 0.8s ease-out;
        }

        .animate-slideInRight {
            animation: slideInRight 0.8s ease-out;
        }

        .animate-pulse-gentle {
            animation: pulse 3s ease-in-out infinite;
        }

        /* Gradient backgrounds */
        .bg-gradient-green {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%);
        }

        .bg-gradient-light {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #bbf7d0 100%);
        }

        .bg-gradient-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6));
        }

        /* Custom shadows */
        .shadow-elegant {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .shadow-card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .shadow-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transform: translateY(-5px);
        }

        /* Arabic text styling */
        .arabic-text {
            font-family: 'Amiri', 'Times New Roman', serif;
            font-size: 2.5rem;
            line-height: 1.4;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Navbar enhancements */
        .navbar-blur {
            backdrop-filter: blur(10px);
            background: rgba(34, 197, 94, 0.95);
        }

        /* Custom borders */
        .border-islamic {
            border: 3px solid;
            border-image: linear-gradient(45deg, #22c55e, #16a34a) 1;
        }

        /* Scroll animations */
        .scroll-animate {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s ease;
        }

        .scroll-animate.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <body class="bg-gradient-light font-sans overflow-x-hidden">
        <!-- Navbar -->
        <header class="w-full navbar-blur text-white py-4 shadow-elegant fixed top-0 z-50 transition-all duration-300">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div class="flex items-center space-x-4 animate-slideInLeft">
                    <div class="relative">
                        <img src="{{ asset('assets/ppmq.png') }}" alt="Logo Pondok"
                            class="h-12 w-12 rounded-full border-2 border-white shadow-lg">
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-yellow-400 rounded-full animate-pulse"></div>
                    </div>
                    <div>
                        <span class="text-xl font-bold">PPMQ Murottil Quran</span>
                        <p class="text-xs opacity-90">Jember, Jawa Timur</p>
                    </div>
                </div>
                <nav class="space-x-8 animate-slideInRight">
                    <a href="#home" class="hover:text-yellow-300 transition-colors duration-300 relative group">
                        Home
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-yellow-300 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#visi" class="hover:text-yellow-300 transition-colors duration-300 relative group">
                        Visi Misi
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-yellow-300 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#program" class="hover:text-yellow-300 transition-colors duration-300 relative group">
                        Program
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-yellow-300 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('ppdb') }}"
                        class="bg-yellow-500 hover:bg-yellow-400 px-4 py-2 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg">
                        PPDB
                    </a>
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section id="home"
            class="min-h-screen flex items-center justify-center text-center bg-cover bg-center relative"
            style="background-image: url('{{ asset('assets/pondok.jpg') }}');">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-hero"></div>

            <!-- Decorative Islamic Pattern -->
            <div class="absolute top-20 left-10 w-20 h-20 border-2 border-white opacity-20 rotate-45 animate-pulse-gentle">
            </div>
            <div class="absolute bottom-20 right-10 w-16 h-16 border-2 border-yellow-300 opacity-30 rotate-12 animate-pulse-gentle"
                style="animation-delay: 1s;"></div>

            <!-- Content -->
            <div
                class="relative z-10 bg-white bg-opacity-95 rounded-2xl p-12 shadow-elegant max-w-2xl mx-4 animate-fadeInUp border-islamic">
                <div class="mb-6">
                    <div class="w-16 h-1 bg-gradient-green mx-auto mb-4"></div>
                    <h1 class="arabic-text text-green-600 mb-4">خَيْرُكُمْ مَنْ تَعَلَّمَ الْقُرْآنَ وَعَلَّمَهُ</h1>
                    <div class="w-16 h-1 bg-gradient-green mx-auto"></div>
                </div>

                <p class="mt-6 text-gray-700 text-lg leading-relaxed font-medium">
                    "Sebaik-baik kalian adalah yang mempelajari Al-Quran dan mengajarkannya"
                </p>
                <p class="mt-4 text-gray-600 italic">— HR. Bukhari —</p>

                <div class="mt-8 flex items-center justify-center space-x-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <p class="text-green-600 font-semibold">PPMQ Murottil Quran</p>
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                </div>
            </div>
        </section>

        <!-- Visi Misi Section -->
        <section id="visi" class="py-20 bg-white relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute top-0 left-0 w-full h-full opacity-5">
                <div class="absolute top-10 left-10 w-32 h-32 border border-green-300 rounded-full"></div>
                <div class="absolute top-32 right-16 w-24 h-24 border border-green-300 rounded-full"></div>
                <div class="absolute bottom-16 left-1/4 w-20 h-20 border border-green-300 rounded-full"></div>
            </div>

            <div class="container mx-auto px-6 text-center relative z-10">
                <div class="scroll-animate">
                    <h2 class="text-4xl font-bold text-green-600 mb-4">Visi & Misi</h2>
                    <div class="w-24 h-1 bg-gradient-green mx-auto mb-12"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-4xl mx-auto">
                    <!-- Visi Card -->
                    <div
                        class="scroll-animate bg-gradient-light p-8 rounded-2xl shadow-card border-l-4 border-green-500 transform transition-all duration-300">
                        <div class="flex items-center justify-center mb-6">
                            <div
                                class="w-16 h-16 bg-gradient-green rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="font-bold text-xl text-green-700 mb-4">VISI</h3>
                        <p class="text-gray-700 leading-relaxed text-lg">
                            Mewujudkan generasi Qurani yang berakhlakul karimah, beriman dan bertaqwa kepada Allah SWT
                        </p>
                    </div>

                    <!-- Misi Card -->
                    <div
                        class="scroll-animate bg-gradient-green text-white p-8 rounded-2xl shadow-card border-l-4 border-yellow-400 transform transition-all duration-300">
                        <div class="flex items-center justify-center mb-6">
                            <div
                                class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd"
                                        d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3h4v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 102 0v2a1 1 0 11-2 0V9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="font-bold text-xl mb-4">MISI</h3>
                        <p class="leading-relaxed text-lg">
                            Menyelenggarakan pendidikan tahfidz Al-Quran, pembelajaran kitab kuning, dan pembentukan
                            karakter santri yang mandiri
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Program Section -->
        <section id="program" class="py-20 bg-gradient-light relative">
            <div class="container mx-auto px-6 text-center">
                <div class="scroll-animate">
                    <h2 class="text-4xl font-bold text-green-600 mb-4">Program Unggulan</h2>
                    <div class="w-24 h-1 bg-gradient-green mx-auto mb-4"></div>
                    <p class="text-gray-600 text-lg mb-12 max-w-2xl mx-auto">
                        Program pendidikan komprehensif yang menggabungkan pembelajaran Al-Quran dengan pembentukan karakter
                        islami
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    <!-- Tahfidz Program -->
                    <div
                        class="scroll-animate bg-white p-8 rounded-2xl shadow-card border-t-4 border-green-500 transform transition-all duration-300 hover:shadow-elegant">
                        <div class="flex items-center justify-center mb-6">
                            <div
                                class="w-20 h-20 bg-gradient-green rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="font-bold text-xl text-green-600 mb-4">Tahfidz Al-Quran</h3>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            Program hafalan Al-Quran 30 juz dengan metode pembelajaran modern dan bimbingan ustadz
                            berpengalaman
                        </p>
                        <div class="text-sm text-green-600 font-semibold">
                            ✓ Target 30 Juz<br>
                            ✓ Metode Talaqi<br>
                            ✓ Muroja'ah Rutin
                        </div>
                    </div>

                    <!-- Kitab Kuning Program -->
                    <div
                        class="scroll-animate bg-white p-8 rounded-2xl shadow-card border-t-4 border-yellow-500 transform transition-all duration-300 hover:shadow-elegant">
                        <div class="flex items-center justify-center mb-6">
                            <div
                                class="w-20 h-20 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 11-2 0v-2a1 1 0 00-1-1H8a1 1 0 00-1 1v2a1 1 0 11-2 0V8a3 3 0 013-3h2a3 3 0 013 3v3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="font-bold text-xl text-green-600 mb-4">Kitab Kuning</h3>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            Pembelajaran kitab klasik untuk mendalami ilmu agama Islam dan memahami khazanah keilmuan ulama
                            terdahulu
                        </p>
                        <div class="text-sm text-green-600 font-semibold">
                            ✓ Fiqh & Ushul Fiqh<br>
                            ✓ Hadits & Tafsir<br>
                            ✓ Bahasa Arab
                        </div>
                    </div>

                    <!-- Kemandirian Program -->
                    <div
                        class="scroll-animate bg-white p-8 rounded-2xl shadow-card border-t-4 border-blue-500 transform transition-all duration-300 hover:shadow-elegant">
                        <div class="flex items-center justify-center mb-6">
                            <div
                                class="w-20 h-20 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="font-bold text-xl text-green-600 mb-4">Pembentukan Karakter</h3>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            Program pengembangan kemandirian santri melalui kegiatan life skill dan pembinaan karakter
                            islami
                        </p>
                        <div class="text-sm text-green-600 font-semibold">
                            ✓ Life Skills<br>
                            ✓ Leadership Training<br>
                            ✓ Entrepreneurship
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="py-16 bg-gradient-green text-white">
            <div class="container mx-auto px-6 text-center">
                <div class="scroll-animate">
                    <h2 class="text-3xl font-bold mb-4">Bergabunglah Bersama Kami</h2>
                    <p class="text-xl mb-8 opacity-90">Wujudkan impian menjadi penghafal Al-Quran yang berakhlak mulia</p>
                    <a href="{{ route('ppdb') }}"
                        class="inline-block bg-yellow-500 hover:bg-yellow-400 text-green-900 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </section>

        <script>
            // Scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            // Observe all scroll-animate elements
            document.querySelectorAll('.scroll-animate').forEach(el => {
                observer.observe(el);
            });

            // Smooth scrolling for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Navbar background change on scroll
            window.addEventListener('scroll', function() {
                const header = document.querySelector('header');
                if (window.scrollY > 100) {
                    header.style.background = 'rgba(34, 197, 94, 0.98)';
                } else {
                    header.style.background = 'rgba(34, 197, 94, 0.95)';
                }
            });
        </script>
    </body>
@endsection
