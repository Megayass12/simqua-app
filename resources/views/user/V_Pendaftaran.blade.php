@extends('master.V_Public')
@section('title', 'Pendaftaran')
@section('content')

<section class="font-sans min-h-screen bg-cover bg-center relative" style="background-image: url('{{ asset('assets/BG-PD.jpg') }}');">
    @include('master.navbar')

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" data-success-alert
            class="fixed bottom-5 right-5 z-60 w-full max-w-sm bg-green-600 text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up transition-all duration-500 ease-in-out">
            <div class="flex-shrink-0 w-10 h-10 bg-white rounded-full flex items-center justify-center">
                <img src="{{ asset('assets/rawlogo.png') }}" alt="Logo" class="h-6 w-6">
            </div>
            <div class="flex-grow">
                <h3 class="text-lg font-bold">Berhasil!</h3>
                <p class="text-sm mt-1">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-white hover:text-gray-200 text-xl leading-none">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" data-error-alert
            class="fixed bottom-5 right-5 z-60 w-full max-w-sm bg-red-600 text-white rounded-xl p-4 shadow-lg flex items-start gap-3 animate-slide-up transition-all duration-500 ease-in-out">
            <div class="flex-shrink-0 w-10 h-10 bg-white rounded-full flex items-center justify-center">
                <img src="{{ asset('assets/rawlogo.png') }}" alt="Logo" class="h-6 w-6">
            </div>
            <div class="flex-grow">
                <h3 class="text-lg font-bold">Alert!</h3>
                <ul class="text-sm mt-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button @click="show = false" class="text-white hover:text-gray-200 text-xl leading-none">&times;</button>
        </div>
    @endif

    <div x-data="{ showTambahPendaftaran: false }" class="flex flex-col items-center justify-center min-h-screen pt-28 px-8 relative z-10">
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
                        @forelse ($data as $item)
                            <tr class="hover:bg-white/10 transition">
                                <td class="p-3 text-center">{{ $item->created_at->format('d-m-Y') }}</td>
                                <td class="p-3 text-center">{{ $item->kode }}</td>
                                <td class="p-3 text-center">{{ $item->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-3 text-center text-gray-400">Tidak ada pendaftaran yang sedang diproses.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form Tambah -->
        <div
            x-show="showTambahPendaftaran" x-cloak x-transition
            class="fixed inset-0 z-60 flex items-center justify-center bg-black/60 backdrop-blur-sm pt-20 pb-10 px-4"
        >
            <div
                @click.outside="showTambahPendaftaran = false"
                class="bg-white p-8 w-full max-w-lg relative text-gray-800 shadow-xl max-h-[80vh] overflow-y-auto rounded-l-2xl"
                style="border-top-right-radius: 0; border-bottom-right-radius: 0;"

            >
                <h2 class="text-2xl font-bold text-center mb-6">Form Pendaftaran Santri Baru</h2>
                <form action="{{ route('pendaftaran.simpan') }}" method="POST" class="space-y-4 min-w-[400px]">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('nama') border-red-500 @enderror">
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('nisn') border-red-500 @enderror">
                        @error('nisn')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat" value="{{ old('tempat') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('tempat') border-red-500 @enderror">
                        @error('tempat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('tanggal') border-red-500 @enderror">
                        @error('tanggal')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Alamat</label>
                        <textarea name="alamat" rows="3"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                            class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('no_hp') border-red-500 @enderror">
                        @error('no_hp')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showTambahPendaftaran = false" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                            Batal
                        </button>
                        <button type="submit" class="px-3 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="w-full max-w-5xl mt-4 mx-auto">
            <button @click="showTambahPendaftaran = true" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500">
                Tambah
            </button>
        </div>
    </div>

    @include('master.footer')
</section>

<script>
    if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
        document.querySelectorAll('[data-success-alert], [data-error-alert]').forEach(alert => alert.remove());
    }
</script>

@endsection
