@extends('master.V_Public')
@section('title', 'Pendaftaran')
@section('content')

<section
    class="font-sans min-h-screen bg-cover bg-center relative"
    style="background-image: url('{{ asset('assets/BG-PD.jpg') }}');"
>
    <!-- Header -->
    @include('master.navbar')

    <!-- Notifikasi Sukses -->
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" data-success-alert
            class="fixed bottom-5 right-5 z-60 w-full max-w-sm bg-green-600 text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up transition-all duration-500 ease-in-out">

            <!-- Logo -->
            <div class="flex-shrink-0 bg-transparent rounded-full w-14 h-14 flex items-center justify-center overflow-hidden">
                <img src="{{ asset('assets/rawlogo.png') }}" alt="Logo" class="h-6 w-6 object-cover">
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
            class="fixed bottom-5 right-5 z-60 w-full max-w-sm bg-red-600 text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up transition-all duration-500 ease-in-out">

            <!-- Logo -->
            <div class="flex-shrink-0 bg-transparent rounded-full w-14 h-14 flex items-center justify-center overflow-hidden">
                <img src="{{ asset('assets/rawlogo.png') }}" alt="Logo" class="h-6 w-6 object-cover">
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

    <!-- Main Content -->
    <div class="flex flex-col items-center justify-center min-h-screen pt-28 px-8 relative z-10">
        <div class="bg-green/10 backdrop-blur-md border border-white/60 rounded-2xl shadow-lg p-6 w-full max-w-5xl">
            <h2 class="text-xl font-semibold text-emerald-900 pl-4 mb-4">Pendaftaran</h2>
            <div class="overflow-y-auto max-h-[300px] min-h-[300px] px-4 custom-scrollbar">
                <table class="min-w-full text-sm text-emerald-900">
                    <thead>
                        <tr class="border-b border-white/60 text-left">
                            <th class="text-center p-3">Tanggal</th>
                            <th class="text-center p-3">Kode Pendaftaran</th>
                            <th class="text-center p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/60">
                        @forelse ($data as $index => $item)
                            <!-- Baris Utama -->
                            <tr class="hover:bg-white/10 transition">
                                <td class="p-3">
                                    <div class="font-bold bg-teal-300/20 backdrop-blur-sm px-3 py-1 rounded-md text-sm flex items-center justify-center">
                                        {{ $item->created_at->format('d-m-Y') }}
                                    </div>
                                </td>
                                <td class="p-3">
                                    <div class="font-bold bg-teal-300/20 backdrop-blur-sm px-3 py-1 rounded-md text-sm flex items-center justify-center">
                                       {{ $item->kode }}
                                    </div>
                                </td>
                                <td class="p-3">
                                    <div class="font-bold flex items-center gap-2 justify-center">
                                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                                        {{ $item->status }}
                                    </div>
                                </td>
                            </tr>
                            <!-- Baris Detail -->
                            <tr class="bg-white/10">
                                <td colspan="4" class="p-4">
                                    <div class="text-emerald-900 space-y-2">
                                        <p><strong>Nama:</strong> {{ $item->nama }}</p>
                                        <p><strong>NISN:</strong> {{ $item->nisn }}</p>
                                        <p><strong>Tempat, Tanggal Lahir:</strong> {{ $item->tempat }}, {{ $item->tanggal }}</p>
                                        <p><strong>Alamat:</strong> {{ $item->alamat }}</p>
                                        <p><strong>No. HP Orang Tua:</strong> {{ $item->no_hp }}</p>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-gray-400">Tidak ada pengajuan yang sedang diproses.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <style>
                /* Scrollbar container */
                .custom-scrollbar::-webkit-scrollbar {
                    width: 6px;
                }

                /* Track (latar belakang) */
                .custom-scrollbar::-webkit-scrollbar-track {
                    background: transparent;
                }

                /* Thumb (batangnya) */
                .custom-scrollbar::-webkit-scrollbar-thumb {
                    background-color: rgba(255, 255, 255, 0.4);
                    border-radius: 9999px;
                }
            </style>
        </div>

        <!-- Tombol Tambah -->
        <div class="w-full max-w-5xl mt-4 mx-auto">
            <div class="flex justify-end">
                <button
                    @click="showTambahPengajuan = true"
                    :disabled="{{ $hasActiveSubmission ? 'true' : 'false' }}"
                    class="px-6 py-2 rounded-lg shadow-md transition z-10
                           {{ $hasActiveSubmission ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-500 text-white' }}">
                    Tambah
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('master.footer')
</section>

<script>
    if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
        const successAlert = document.querySelector('[data-success-alert]');
        if (successAlert) successAlert.remove();

        const errorAlert = document.querySelector('[data-error-alert]');
        if (errorAlert) errorAlert.remove();
    }
</script>
@endsection
