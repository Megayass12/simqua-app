@extends('master.V_Public')
@section('title', 'Verifikasi')
@section('content')

    <section x-data="pendaftaranModal" class="font-sans min-h-screen bg-cover bg-center relative"
        style="background-image: url({{ asset('assets/BG-PD.jpg') }})">

        <!-- Header -->
        @include('master.navbar')

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" data-success-alert
                class="fixed bottom-5 right-5 z-50 w-full max-w-sm bg-green-600 text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up transition-all duration-500 ease-in-out">

                <!-- Logo -->
                <div
                    class="flex-shrink-0 bg-transparent rounded-full w-14 h-14 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('assets/ppmq.png') }}" alt="PPMQ Logo" class="h-6 w-6 object-cover">
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

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" data-error-alert
                class="fixed bottom-5 right-5 z-50 w-full max-w-sm bg-red-600 text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up transition-all duration-500 ease-in-out">

                <div
                    class="flex-shrink-0 bg-transparent rounded-full w-14 h-14 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('assets/ppmq.png') }}" alt="PPMQ Logo" class="h-6 w-6 object-cover">
                </div>

                <div class="flex-grow">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold">Gagal!</h3>
                        <button @click="show = false"
                            class="text-white hover:text-gray-200 text-xl leading-none">&times;</button>
                    </div>
                    <p class="text-sm mt-1">{{ session('error') }}</p>
                </div>
            </div>
        @endif


        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center min-h-screen pt-16 px-8 relative z-10">
            <div class="h-[5%] w-full bg-gradient-to-t from-slate-950 to-transparent absolute bottom-0 z-10"></div>

            <div class="bg-white border border-white/60 rounded-2xl shadow-lg p-6 w-full max-w-5xl">
                <h2 class="text-xl font-semibold text-green-600 pl-4 mb-4">Daftar Registrasi PPMQ Murottilil Qur'an</h2>
                <div class="overflow-y-auto max-h-[300px] min-h-[300px] px-4 custom-scrollbar">
                    <table class="min-w-full text-sm text-black">
                        <thead>
                            <tr class="border-b border-white/60 text-left">
                                <th class="p-3">No.</th>
                                <th class="p-3">Nama</th>
                                <th class="p-3">NISN</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/60">
                            @forelse ($data as $index => $item)
                                <tr class="hover:bg-white/10 transition">
                                    <td class="p-3">{{ $index + 1 }}</td>
                                    <td class="p-3">{{ $item->nama }}</td>
                                    <td class="p-3">{{ $item->nisn }}</td>
                                    <td class="p-3">
                                        <div class="flex items-center gap-2">
                                            @php
                                                $warna = match ($item->status) {
                                                    'Proses' => 'bg-blue-500',
                                                    'Disetujui' => 'bg-green-500',
                                                    'Ditolak' => 'bg-red-500',
                                                };
                                            @endphp
                                            <span class="w-3 h-3 rounded-full {{ $warna }}"></span>
                                            {{ $item->status }}
                                        </div>
                                    </td>
                                    <td class="p-3 text-center">
                                        <button
                                            @click="openDetail({
                                                id: '{{ $item->id }}',
                                                nama: '{{ $item->nama }}',
                                                nisn: '{{ $item->nisn }}',
                                                email: '{{ $item->user->email ?? '-' }}',
                                                no_hp: '{{ $item->no_hp }}',
                                                tempat: '{{ $item->tempat }}',
                                                tanggal: '{{ $item->tanggal }}',
                                                alamat: '{{ $item->alamat }}',
                                                status: '{{ $item->status }}'
                                            })"
                                            class="bg-green-500 hover:bg-green-700 text-white px-4 py-1 rounded-md transition">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-3 text-center text-gray-400">Tidak ada user yang menunggu
                                        verifikasi.</td>
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
                        /* warna putih transparan */
                        border-radius: 9999px;
                    }
                </style>
            </div>
        </div>

        <!-- Modal Detail Pendaftar -->
        <div x-show="showDetailModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.outside="showDetailModal = false"
                class="bg-white rounded-2xl p-8 w-[800px] max-w-full relative text-gray-800 shadow-xl bg-fit bg-center">

                <h2 class="text-2xl font-bold text-center mb-6">Detail Pendaftar</h2>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold mb-1">Nama</label>
                            <input type="text" x-model="detailUser.nama"
                                class="w-full bg-gray-100 border rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold mb-1">NISN</label>
                            <input type="text" x-model="detailUser.nisn"
                                class="w-full bg-gray-100 border rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold mb-1">Email</label>
                            <input type="text" x-model="detailUser.email"
                                class="w-full bg-gray-100 border rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold mb-1">Nomor Handphone</label>
                            <input type="text" x-model="detailUser.no_hp"
                                class="w-full bg-gray-100 border rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold mb-1">Tempat</label>
                            <input type="text" x-model="detailUser.tempat"
                                class="w-full bg-gray-100 border rounded-lg px-4 py-2" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold mb-1">Tanggal</label>
                            <input type="text" x-model="detailUser.tanggal"
                                class="w-full bg-gray-100 border rounded-lg px-4 py-2" readonly>
                        </div>
                        <div class="col-span-2">
                            <label class="text-sm font-semibold mb-1">Alamat</label>
                            <textarea x-model="detailUser.alamat" rows="2" class="resize-none w-full bg-gray-100 border rounded-lg px-4 py-2"
                                readonly></textarea>
                        </div>
                    </div>

                    <div class="relative flex justify-end mt-6 space-x-3">
                        <!-- Tampilkan status saat ini -->
                        <div class="flex items-center gap-2 mr-4">
                            <span class="text-sm font-semibold">Status:</span>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full"
                                    :class="{
                                        'bg-blue-500': detailUser.status === 'Proses',
                                        'bg-green-500': detailUser.status === 'Disetujui',
                                        'bg-red-500': detailUser.status === 'Ditolak'
                                    }"></span>
                                <span x-text="detailUser.status" class="text-sm font-medium"></span>
                            </div>
                        </div>

                        <div class="relative" x-data="{ openDropdown: false }">
                            <!-- Tombol Verifikasi - hanya aktif jika status = 'Proses' -->
                            <template x-if="detailUser.status === 'Proses'">
                                <button @click="openDropdown = !openDropdown"
                                    class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg font-semibold transition">
                                    Verifikasi
                                </button>
                            </template>

                            <!-- Tombol disabled jika status bukan 'Proses' -->
                            <template x-if="detailUser.status !== 'Proses'">
                                <button disabled
                                    class="bg-gray-400 text-white px-6 py-2 rounded-lg font-semibold cursor-not-allowed opacity-50">
                                    Sudah Diverifikasi
                                </button>
                            </template>

                            <!-- Dropdown - hanya muncul jika status = 'Proses' -->
                            <div x-show="openDropdown && detailUser.status === 'Proses'"
                                @click.outside="openDropdown = false" x-cloak
                                class="absolute right-0 mt-2 bg-white shadow-lg rounded-xl border px-4 py-3 flex gap-3 z-50">

                                <!-- Tombol Terima -->
                                <form method="POST" :action="'/admin/verifikasi/' + detailUser.id + '/Disetujui'">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="text-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold">
                                        Terima
                                    </button>
                                </form>

                                <!-- Tombol Tolak -->
                                <form method="POST" :action="'/admin/verifikasi/' + detailUser.id + '/Ditolak'">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="text-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Tombol Tutup -->
                        <button @click="showDetailModal = false"
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("pendaftaranModal", () => ({
                showDetailModal: false,
                detailUser: {
                    id: '',
                    nama: '',
                    nisn: '',
                    email: '',
                    no_hp: '',
                    tempat: '',
                    tanggal: '',
                    alamat: '',
                    status: '',
                },
                openDetail(user) {
                    this.detailUser = user;
                    this.showDetailModal = true;
                },
                verifikasi(statusBaru) {
                    // Cek apakah status masih 'Proses' sebelum melakukan verifikasi
                    if (this.detailUser.status !== 'Proses') {
                        alert('Status sudah diubah, tidak dapat melakukan verifikasi lagi.');
                        return;
                    }

                    fetch(`/admin/verifikasi/${this.detailUser.id}/${statusBaru}`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => {
                            if (response.ok) {
                                // Update status di frontend
                                this.detailUser.status = statusBaru;

                                // Refresh halaman setelah berhasil untuk update tabel
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);

                                this.showDetailModal = false;
                            } else {
                                console.error('Gagal memperbarui status:', response.statusText);
                            }
                        })
                        .catch(error => {
                            console.error('Terjadi kesalahan:', error);
                        });
                },
            }));
        });
    </script>

@endsection
