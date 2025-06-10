@extends('master.V_Public')
@section('title', 'Daftar Ulang')
@section('content')

<section class="font-sans min-h-screen bg-cover bg-center relative"
    style="background-image: url('{{ asset('assets/BG-PD.jpg') }}');">

    <!-- Header -->
    @include('master.navbar')

    <!-- Notifikasi Sukses -->
    @if (session('success'))
        <div class="fixed bottom-5 right-5 z-60 w-full max-w-sm bg-green-600 text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up">
            <div class="flex-grow">
                <h3 class="text-lg font-bold">Berhasil!</h3>
                <p class="text-sm mt-1">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="flex flex-col items-center justify-center min-h-screen pt-28 px-8 relative z-10">
        <div class="bg-white border-emerald-900/60 rounded-2xl shadow-lg p-6 w-full max-w-5xl">
            <h2 class="text-xl font-semibold text-emerald-900 pl-4 mb-4">Daftar Ulang</h2>
            <div class="overflow-y-auto max-h-[400px] px-4 custom-scrollbar">
                <table class="min-w-full text-sm text-white">
                    <thead>
                        <tr class="border-b border-emerald-900/60 text-left">
                            <th class="p-3 text-emerald-900">Kode Pendaftaran</th>
                            <th class="p-3 text-center text-emerald-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/60">
                        @forelse ($data as $item)
                            <tr>
                                <td class="p-3">{{ $item->kode }}</td>
                                <td class="p-3 text-center">
                                    <button @click="openForm('{{ $item->kode }}')"
                                        class="bg-green-500 hover:bg-green-700 text-white px-4 py-1 rounded-md transition">
                                        Daftar Ulang
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="p-3 text-center text-emerald-900">Tidak ada pendaftaran yang sudah disetujui.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Form Daftar Ulang -->
    <div x-show="showForm" x-cloak x-transition
        class="fixed inset-0 z-40 flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-white rounded-2xl p-6 w-[400px] max-w-full relative text-gray-800 shadow-xl">
            <h2 class="text-2xl font-bold text-center mb-4">Form Daftar Ulang</h2>
            <form action="{{ route('daftarUlang.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Kode Pendaftaran</label>
                    <input type="text" name="kode" x-model="kodePendaftaran" readonly
                        class="w-full border rounded-lg px-4 py-2 bg-gray-100">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Scan Kartu Keluarga (PDF, JPG, PNG)</label>
                    <input type="file" name="kartu_keluarga" accept=".pdf,.jpg,.jpeg,.png" required
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Scan Akta Kelahiran (PDF, JPG, PNG)</label>
                    <input type="file" name="akta_kelahiran" accept=".pdf,.jpg,.jpeg,.png" required
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="showForm = false"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                        Daftar Ulang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Alpine.js Script -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('daftarUlang', () => ({
                showForm: false,
                kodePendaftaran: '',
                openForm(kode) {
                    this.kodePendaftaran = kode;
                    this.showForm = true;
                }
            }));
        });
    </script>
</section>

@endsection
