@extends('master.V_Public')
@section('title', 'Informasi')
@section('content')

    <section x-data="profilModal" class="font-sans min-h-screen bg-cover">

        <!-- Header -->
        @include('master.navbar')
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <h1 class="{{ $isAdmin ? 'text-4xl' : 'text-2xl md:text-3xl' }} font-bold {{ $isAdmin ? 'text-center mb-10' : 'mb-6 text-gray-800' }}">
                Katalog Produk
            </h1>

            @if($isAdmin)
                <div class="flex flex-wrap justify-center gap-5">
                    @if($katalogs->isEmpty())
                        <div class="text-center text-gray-500 w-full text-lg">
                            Belum ada produk di katalog. Silakan tambahkan produk terlebih dahulu.
                        </div>
                    @else
                        @foreach ($katalogs as $product)
                            <a href="{{ route('admin.katalog.edit', $product->id) }}"
                                class="bg-white w-[200px] rounded-2xl p-3 shadow-md transition duration-300 hover:shadow-lg hover:scale-105">
                                <img src="{{ asset('storage/' . $product->foto) }}"
                                        alt="{{ $product->nama_produk }}"
                                        class="w-full h-40 object-cover rounded-md">
                                <p class="text-secondary font-medium mt-2">{{ $product->nama_produk }}</p>
                                <p class="text-accent font-medium">RP {{ number_format($product->harga, 0, ',', '.') }}</p>
                                <p class="text-gray-500 text-sm">Stok: {{ $product->stok }}</p>
                            </a>
                        @endforeach
                    @endif

                    <div class="relative mt-5">
                        <a href="{{ route('admin.katalog.create') }}">
                            <button class="bg-secondary text-white py-3 px-6 rounded-xl fixed bottom-10 right-10
                                        transition-all duration-300 ease-in-out
                                        hover:bg-secondary/90 hover:shadow-lg">
                                + Tambah Produk
                            </button>
                        </a>
                    </div>
                </div>

            @elseif($isCustomer)
                <div class="container mx-auto px-4 py-4">
                    <form action="{{ route('KlikBeliSekarang') }}" method="POST">
                        @csrf

                        @if($katalogs->isEmpty())
                            <div class="text-center text-gray-500 text-lg py-10 col-span-full">
                                Belum ada produk tersedia di katalog saat ini.
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                @foreach($katalogs as $katalog)
                                    <div class="border rounded-lg p-5 shadow-sm hover:shadow-md transition duration-300 bg-white cursor-pointer"
                                        onclick="showProductDetail({{ json_encode($katalog) }})">
                                        <label class="flex items-center cursor-pointer mb-5" onclick="event.stopPropagation()">
                                            <input type="checkbox" name="katalog[]" value="{{ $katalog->id }}"
                                                class="rounded text-blue-600 focus:ring-blue-500 h-5 w-5">
                                            <span class="ml-3 text-blue-700">Pilih Produk Ini</span>
                                        </label>

                                        <div class="h-40 bg-gray-100 rounded-md mb-4 flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $katalog->foto) }}"
                                                alt="{{ $katalog->nama_produk }}"
                                                class="w-full h-40 object-cover rounded-md">
                                        </div>
                                        <h2 class="font-semibold text-lg text-gray-800 mb-1">{{ $katalog->nama_produk }}</h2>
                                        <p class="text-blue-600 font-medium mb-1">Rp{{ number_format($katalog->harga, 0, ',', '.') }}</p>
                                        <p class="text-cyan-600 font-medium mb-3">Stok: {{ $katalog->stok }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Tombol Beli Sekarang -->
                            <div class="mt-8 sticky bottom-4 z-10 flex justify-end">
                                <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md transition duration-300 focus:outline-none">
                                    Beli Sekarang
                                </button>
                            </div>

                            <!-- Modal Detail Produk -->
                            <div id="productModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                                <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4 sm:mx-0">
                                    <div class="p-6">
                                        <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Detail Produk</h2>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                                            <p id="modalTitle" class="text-lg font-semibold text-gray-900"></p>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
                                            <img id="modalImage" src="" alt="" class="w-full h-56 object-cover rounded-md">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                                            <p id="modalPrice" class="text-blue-600 font-bold text-lg"></p>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                                            <p id="modalStock" class="text-cyan-600"></p>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                            <p id="modalDescription" class="text-gray-700"></p>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                                        <button type="button" onclick="closeModal()" class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-800 font-medium py-2 px-4 rounded-lg transition">Tutup</button>
                                        <button type="button" onclick="addToCart()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">Tambah ke Keranjang</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            @endif

            @if($isCustomer)
            <script>
                let selectedProduct = null;

                function showProductDetail(product) {
                    selectedProduct = product;
                    document.getElementById('modalTitle').textContent = product.nama_produk;
                    document.getElementById('modalImage').src = "{{ asset('storage') }}/" + product.foto;
                    document.getElementById('modalPrice').textContent = 'Rp' + parseInt(product.harga).toLocaleString('id-ID');
                    document.getElementById('modalStock').textContent = 'Stok: ' + product.stok;
                    document.getElementById('modalDescription').textContent = product.deskripsi || 'Tidak ada deskripsi tersedia';

                    document.getElementById('productModal').classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                }

                function closeModal() {
                    document.getElementById('productModal').classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }

                function addToCart() {
                    if (selectedProduct) {
                        const checkbox = document.querySelector(`input[type="checkbox"][value="${selectedProduct.id}"]`);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                        closeModal();
                    }
                }

                // Close modal when clicking outside
                document.getElementById('productModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeModal();
                    }
                });
            </script>
            @endif
            @endsection

