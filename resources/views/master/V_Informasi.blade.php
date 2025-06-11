@extends('master.V_Public')
@section('title', 'Informasi')
@section('content')

<section class="font-sans min-h-screen bg-cover">
    <!-- Header -->
    @include('master.navbar')
    
    <div class="container mx-auto px-4 py-8">
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
            Informasi
        </h1>

        @if($isAdmin)
            <div class="flex flex-wrap justify-center gap-5">
                @if($informasi->isEmpty())
                    <div class="text-center text-gray-500 w-full text-lg">
                        Belum ada informasi tersedia.
                    </div>
                @else
                    @foreach ($informasi as $info)
                        <div onclick="showEditModal({{ $info->id }})"
                            class="bg-white w-[200px] rounded-2xl p-3 shadow-md transition duration-300 hover:shadow-lg hover:scale-105 cursor-pointer">
                            <img src="{{ asset('storage/' . $info->foto) }}"
                                    alt="{{ $info->judul }}"
                                    class="w-full h-40 object-cover rounded-md">
                            <p class="text-secondary font-medium mt-2">{{ $info->judul }}</p>
                        </div>
                    @endforeach
                @endif

                <div class="relative mt-5">
                    <button onclick="showAddModal()"
                            class="bg-secondary text-white py-3 px-6 rounded-xl fixed bottom-10 right-10
                                    transition-all duration-300 ease-in-out
                                    hover:bg-secondary/90 hover:shadow-lg">
                        + Tambah Informasi
                    </button>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($informasi as $info)
                    <div onclick="showDetailModal({{ $info->id }})"
                        class="bg-white rounded-2xl p-3 shadow-md transition duration-300 hover:shadow-lg hover:scale-105 cursor-pointer">
                        <img src="{{ asset('storage/' . $info->foto) }}"
                                alt="{{ $info->judul }}"
                                class="w-full h-40 object-cover rounded-md">
                        <p class="text-secondary font-medium mt-2">{{ $info->judul }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Modal for Add/Edit (Admin) -->
    @if($isAdmin)
    <div id="infoModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4 sm:mx-0">
            <div class="p-6">
                <h2 id="modalTitle" class="text-2xl font-semibold text-gray-800 mb-4 text-center"></h2>
                <form id="infoForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="infoId" name="id">
                    
                    <div class="mb-4">
                        <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                        <input type="text" id="judul" name="judul" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    
                    <div class="mb-4">
                        <label for="informasi" class="block text-sm font-medium text-gray-700 mb-1">Informasi</label>
                        <textarea id="informasi" name="informasi" rows="4" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                        <input type="file" id="foto" name="foto" accept="image/*"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <img id="previewImage" src="" alt="" class="mt-2 w-full h-40 object-cover hidden">
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal for Detail (Calon Santri) -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4 sm:mx-0">
            <div class="p-6">
                <h2 id="detailTitle" class="text-2xl font-semibold text-gray-800 mb-4 text-center"></h2>
                <img id="detailImage" src="" alt="" class="w-full h-56 object-cover rounded-md mb-4">
                <div id="detailContent" class="text-gray-700"></div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button onclick="closeDetailModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</section>

<script>
    // For Admin
    function showAddModal() {
        document.getElementById('modalTitle').textContent = 'Tambah Informasi';
        document.getElementById('infoForm').action = "{{ route('informasi.store') }}";
        document.getElementById('infoForm').method = "POST";
        document.getElementById('judul').value = '';
        document.getElementById('informasi').value = '';
        document.getElementById('previewImage').classList.add('hidden');
        document.getElementById('infoModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function showEditModal(id) {
        fetch(`/informasi/${id}/detail`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalTitle').textContent = 'Edit Informasi';
                document.getElementById('infoForm').action = `/informasi/${id}/update`;
                document.getElementById('infoForm').method = "POST";
                document.getElementById('infoId').value = id;
                document.getElementById('judul').value = data.judul;
                document.getElementById('informasi').value = data.informasi;
                
                const previewImage = document.getElementById('previewImage');
                if (data.foto) {
                    previewImage.src = "{{ asset('storage') }}/" + data.foto;
                    previewImage.classList.remove('hidden');
                } else {
                    previewImage.classList.add('hidden');
                }
                
                document.getElementById('infoModal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
    }

    function closeModal() {
        document.getElementById('infoModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // For Calon Santri
    function showDetailModal(id) {
        fetch(`/informasi/${id}/detail`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('detailTitle').textContent = data.judul;
                document.getElementById('detailImage').src = "{{ asset('storage') }}/" + data.foto;
                document.getElementById('detailContent').textContent = data.informasi;
                document.getElementById('detailModal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Preview image when file selected
    document.getElementById('foto')?.addEventListener('change', function(e) {
        const previewImage = document.getElementById('previewImage');
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove('hidden');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@endsection