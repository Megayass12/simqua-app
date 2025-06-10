@extends('master.V_Public')
@section('title', 'Dashboard')
@section('content')

    <section class="font-sans min-h-screen bg-cover bg-center"
        style="background-image: url({{ asset('assets/pondok.jpg') }})">

        <!-- Header -->
        @include('master.navbar')

        <!-- Hero + Cards Container -->
        <div class="flex flex-col items-center justify-end min-h-screen pt-30 relative">
            <div class="h-[5%] w-full bg-gradient-to-t from-slate-950 to-transparent -bottom-0 absolute z-10">
            </div>
        </div>

        <div class="absolute inset-0 bg-cover bg-center"
         style="background-image: url({{ asset('assets/BG-PD.jpg') }});">
        </div>

        {{-- Footer --}}
    @include('master.footer')
    </section>
@endsection
