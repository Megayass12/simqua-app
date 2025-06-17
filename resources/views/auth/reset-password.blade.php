@extends('master.V_Public')
@section('title', 'Reset Password')
@section('content')

    <section class="font-sans h-screen bg-cover bg-center min-h-screen flex items-center justify-center"
        style="background-image: url({{ asset('assets/pondok.jpg') }})">

        <!-- Header -->
        <header class="absolute top-0 left-0 w-full z-50 px-10 py-4">
            <!-- Logo Container -->
            <div class="flex items-center bg-white/10 backdrop-blur-md rounded-full px-8 py-3 shadow-lg">
                <img src="{{ asset('assets/ppmq.png') }}" alt="PPMQ Logo" class="h-12">
                <span class="ml-4 text-emerald-950 text-xl font-semibold tracking-wide">PPMQ GUMUK KEMBAR</span>
            </div>
        </header>

        <div class="bg-white/70 backdrop-blur-md rounded-3xl p-10 w-full max-w-md relative shadow-xl bg-fit bg-center"
            style="background-image: url('{{ asset('assets/bg-form.png') }}')">
            <h2 class="text-3xl font-bold text-black mb-8">Reset Password</h2>
            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Email</label>
                    <input type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                        placeholder="Masukkan email Anda"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-green-500">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Password Baru</label>
                    <input type="password" name="password" required placeholder="Masukkan password baru"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-green-500">
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 font-medium">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password baru"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-green-500">
                </div>
                <button type="submit"
                    class="w-full bg-green-500 text-white font-semibold py-3 rounded-lg hover:bg-green-800 transition">
                    Reset Password
                </button>
            </form>
        </div>
    </section>

@endsection
