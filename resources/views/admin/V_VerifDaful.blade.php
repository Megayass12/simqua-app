@extends('master.V_Public')
@section('title', 'Verifikasi Daftar Ulang')
@section('content')

<section x-data="verifDaful" class="font-sans min-h-screen bg-cover bg-center relative"
    style="background-image: url('{{ asset('assets/BG-PD.jpg') }}');">

    <!-- Header -->
    @include('master.navbar')

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="fixed bottom-5 right-5 z-[9999] w-full max-w-sm bg-green-600 text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up">
            <div class="flex-grow">
                <h3 class="text-lg font-bold">Berhasil!</h3>
                <p class="text-sm mt-1">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="fixed bottom-5 right-5 z-[9999] w-full max-w-sm bg-red-600 text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up">
            <div class="flex-grow">
                <h3 class="text-lg font-bold">Gagal!</h3>
                <p class="text-sm mt-1">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="flex flex-col items-center justify-center min-h-screen pt-28 px-8 relative z-10">
        <div class="bg-white border-emerald-900/60 rounded-2xl shadow-lg p-6 w-full max-w-5xl">
            <h2 class="text-xl font-semibold text-emerald-900 pl-4 mb-4">Verifikasi Daftar Ulang</h2>
            <div class="overflow-y-auto max-h-[500px] px-4 custom-scrollbar">
                <table class="min-w-full text-sm text-emerald-900">
                    <thead>
                        <tr class="border-b border-emerald-900/60 text-left">
                            <th class="p-3">No.</th>
                            <th class="p-3">Kode</th>
                            <th class="p-3">Nama</th>
                            <th class="p-3">File KK</th>
                            <th class="p-3">File Akta</th>
                            <th class="p-3">Kode Pembayaran</th>
                            <th class="p-3">Status Pembayaran</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/60">
                        @forelse ($data as $index => $item)
                            <tr id="row-{{ $item->id }}">
                                <td class="p-3">{{ $index + 1 }}</td>
                                <td class="p-3">{{ $item->kode }}</td>
                                <td class="p-3">{{ $item->nama }}</td>
                                <td class="p-3">
                                    @if($item->file_kk)
                                        <a href="{{ asset('storage/'.$item->file_kk) }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            Lihat File
                                        </a>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    @if($item->file_akta)
                                        <a href="{{ asset('storage/'.$item->file_akta) }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            Lihat File
                                        </a>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="p-3 kode-pembayaran">
                                    {{ $item->kode_pembayaran ?? '-' }}
                                </td>
                                <td class="p-3 text-center">
                                    <span class="px-2 py-1 rounded-full text-xs status-badge
                                        @if($item->status_pembayaran == 'Lunas') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $item->status_pembayaran }}
                                    </span>
                                </td>
                                <td class="p-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        @if($item->file_kk && $item->file_akta)
                                            <button @click="openModal('{{ $item->id }}', '{{ $item->kode }}', '{{ $item->status_pembayaran }}')"
                                                class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-sm transition">
                                                Update Status
                                            </button>
                                        @else
                                            <span class="text-gray-500 text-sm">Belum upload file</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-3 text-center text-emerald-900">Tidak ada data daftar ulang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Update Status -->
    <div x-show="showModal" x-cloak x-transition
        class="fixed inset-0 z-40 flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-white rounded-2xl p-6 w-[400px] max-w-full relative text-gray-800 shadow-xl">
            <h2 class="text-xl font-bold text-center mb-4">Update Status Pembayaran</h2>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Kode Pendaftaran</label>
                <input type="text" x-model="kodePendaftaran" readonly
                    class="w-full border rounded-lg px-4 py-2 bg-gray-100">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Status Pembayaran</label>
                <select x-model="selectedStatus" class="w-full border rounded-lg px-4 py-2 focus:outline-none">
                    <option value="Belum Dibayar">Belum Dibayar</option>
                    <option value="Lunas">Lunas</option>
                </select>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button @click="showModal = false"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    Batal
                </button>
                <button @click="updateStatus()" x-text="isLoading ? 'Memproses...' : 'Simpan'"
                    :disabled="isLoading"
                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 disabled:bg-green-300">
                    Simpan
                </button>
            </div>
        </div>
    </div>

    <!-- Alpine.js Script -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('verifDaful', () => ({
                showModal: false,
                pendaftaranId: null,
                kodePendaftaran: '',
                selectedStatus: 'Belum Dibayar',
                isLoading: false,

                openModal(id, kode, status) {
                    this.pendaftaranId = id;
                    this.kodePendaftaran = kode;
                    this.selectedStatus = status;
                    this.showModal = true;
                },

                async updateStatus() {
                    if (!this.pendaftaranId) return;

                    this.isLoading = true;

                    try {
                        const response = await fetch(`/admin/daftar-ulang/${this.pendaftaranId}/update-status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                status: this.selectedStatus
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Gagal mengupdate status');
                        }

                        if (data.success) {
                            // Update the UI without reloading
                            const row = document.querySelector(`#row-${this.pendaftaranId}`);
                            if (row) {
                                const statusBadge = row.querySelector('.status-badge');
                                if (statusBadge) {
                                    statusBadge.textContent = data.data.status_pembayaran;
                                    statusBadge.className = `px-2 py-1 rounded-full text-xs ${
                                        data.data.status_pembayaran === 'Lunas'
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-gray-100 text-gray-800'
                                    }`;
                                }

                                const kodeCell = row.querySelector('.kode-pembayaran');
                                if (kodeCell && data.data.kode_pembayaran) {
                                    kodeCell.textContent = data.data.kode_pembayaran;
                                }
                            }

                            this.showModal = false;
                            this.showAlert('success', 'Status berhasil diupdate');
                        } else {
                            throw new Error(data.message || 'Gagal mengupdate status');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.showAlert('error', error.message);
                    } finally {
                        this.isLoading = false;
                    }
                },

                showAlert(type, message) {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = `fixed bottom-5 right-5 z-60 w-full max-w-sm ${
                        type === 'success' ? 'bg-green-600' : 'bg-red-600'
                    } text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up`;

                    alertDiv.innerHTML = `
                        <div class="flex-grow">
                            <h3 class="text-lg font-bold">${type === 'success' ? 'Berhasil!' : 'Gagal!'}</h3>
                            <p class="text-sm mt-1">${message}</p>
                        </div>
                    `;

                    document.body.appendChild(alertDiv);

                    setTimeout(() => {
                        alertDiv.remove();
                    }, 5000);
                }
            }));
        });
    </script>
</section>

@endsection
