@extends('master.V_Public')
@section('title', 'Profil')
@section('content')

    <section x-data="profilModal" class="font-sans min-h-screen bg-cover">

        <!-- Header -->
        @include('master.navbar')

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" data-success-alert
                class="fixed bottom-5 right-5 z-50 w-full max-w-sm bg-green-600 text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up transition-all duration-500 ease-in-out">

                <!-- Logo -->
                <div
                    class="flex-shrink-0 bg-transparent rounded-full w-14 h-14 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('assets/ppmq.png') }}" alt="Logo" class="h-6 w-6 object-cover">
                </div>

                <!-- Isi alert -->
                <div class="flex-grow">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold">Berhasil!</h3>
                        <button @click="show = false"
                            class="text-white hover:text-gray-200 text-xl leading-none">&times;</button>
                    </div>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Notifikasi Gagal Validasi -->
        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" data-error-alert
                class="fixed bottom-5 right-5 z-50 w-full max-w-sm bg-red-600 text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up transition-all duration-500 ease-in-out">

                <!-- Logo -->
                <div
                    class="flex-shrink-0 bg-transparent rounded-full w-14 h-14 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('assets/ppmq.png') }}" alt="Logo" class="h-6 w-6 object-cover">
                </div>

                <!-- Isi alert -->
                <div class="flex-grow">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold">Alert!</h3>
                        <button @click="show = false"
                            class="text-white hover:text-gray-200 text-xl leading-none">&times;</button>
                    </div>
                    <ul class="text-sm mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- MAIN -->
        <div class="flex items-center justify-center min-h-screen bg-cover px-4 py-8" 
            style="background-image: url({{ asset('assets/BG-PD.jpg') }})">
            <div class="w-full max-w-2xl bg-white border-black/60 rounded-2xl shadow-lg p-6 text-emerald-900 relative">
                <!-- HEADER -->
                <div class="flex flex-col items-center mb-6 border-b border-emerald-900 pb-4">
                    <h2 class="text-2xl font-semibold">Profil Anda</h2>
                </div>

                <!-- ISI PROFIL -->
                <div class="space-y-4">
                    <div class="flex justify-between border-b border-emerald-900 py-2">
                        <span>Email</span>
                        <span class="text-right">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="flex justify-between border-b border-emerald-900 py-2">
                        <span>Password</span>
                        <span class="text-right">{{ Auth::user()->password }}</span>
                    </div>
                </div>

                <!-- TOMBOL DI BAWAH -->
                <div class="flex justify-start gap-4 mt-8">
                    <!-- Tombol Logout -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button
                            class="bg-orange-600 text-white py-2 px-4 rounded flex items-center gap-2 transition-all hover:bg-orange-700">
                            <span>Keluar</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M5 22C4.44772 22 4 21.5523 4 21V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V6H18V4H6V20H18V18H20V21C20 21.5523 19.5523 22 19 22H5ZM18 16V13H11V11H18V8L23 12L18 16Z" />
                            </svg>
                        </button>
                    </form>

                    <!-- Tombol Ubah -->
                    <button @click="showUbahProfil = true"
                        class="bg-white text-black border-2 border-green-900 font-semibold py-2 px-4 rounded hover:bg-green-900 hover:border-white hover:text-white">
                        Ubah Profil
                    </button>
                </div>
            </div>
        </div>


        <!-- Modal Ubah Profil -->
        <div x-show="showUbahProfil" x-cloak x-transition
            class="fixed inset-0 z-40 flex items-center justify-center pt-4 bg-black/60 backdrop-blur-sm">
            <div @click.outside="showUbahProfil = false"
                class="bg-white rounded-2xl p-8 w-[400px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center"
                style="background-image: url('{{ asset('assets/bg-form.png') }}')">

                <h2 class="text-2xl font-bold text-center mb-6">Ubah Profil</h2>

                <form action="{{ route('profil.update') }}" method="POST" class="space-y-2">
                    @method('PUT')
                    @csrf
                    @if (!Auth::user()->isAdmin())
                    <div>
                        <label class="block text-sm font-semibold mb-1">Email</label>
                        <input type="text" name="email"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Password">
                    </div>
                    @endif
                    @if (Auth::user()->isAdmin())
                        <small class="text-muted">Admin tidak dapat mengubah email.</small>
                    @endif

                    <div>
                        <label class="block text-sm font-semibold mb-1">Password</label>
                        <input type="password" name="password"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan Password">
                    </div>

                    <div class="flex justify-between ">
                        <button type="button" @click="showUbahProfil = false"
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg w-1/2 mr-2 font-semibold">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg w-1/2 ml-2 font-semibold">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Footer --}}
        @include('master.footer')

    </section>
    <script>
        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            const successAlert = document.querySelector('[data-success-alert]');
            if (successAlert) successAlert.remove();

            const errorAlert = document.querySelector('[data-error-alert]');
            if (errorAlert) errorAlert.remove();
        }

        document.addEventListener("alpine:init", () => {
            Alpine.data("profilModal", () => ({
                showUbahProfil: @json($errors->any()),
            }))
        });

        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            history.replaceState(null, '', location.href);
            location.reload();
        }
    </script>

@endsection
