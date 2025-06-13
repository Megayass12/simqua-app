@extends('master.V_Public')
@section('title', 'Informasi')

@section('content')
<section class="min-h-screen bg-gray-50 py-10">
    @include('master.navbar')

    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Informasi</h1>

        @if($isAdmin)
            <div class="text-right mb-6">
                <button onclick="showAddModal()"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    + Tambah Informasi
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($informasi as $info)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4 relative">
                    <img src="{{ asset('storage/' . $info->foto) }}"
                        alt="{{ $info->judul }}"
                        class="w-full h-48 object-cover rounded cursor-pointer"
                        onclick="showDetailModal({{ $info->id }})">
                    <h2 class="mt-3 text-lg font-semibold text-gray-700 cursor-pointer" onclick="showDetailModal({{ $info->id }})">
                        {{ $info->judul }}
                    </h2>

                    @if($isAdmin)
                    <div class="absolute top-2 right-2 flex gap-2">
                        <button onclick="showEditModal({{ $info->id }})"
                                class="bg-yellow-500 text-white px-2 py-1 text-xs rounded hover:bg-yellow-600">
                            Edit
                        </button>
                        <button onclick="deleteInformasi({{ $info->id }})"
                                class="bg-red-600 text-white px-2 py-1 text-xs rounded hover:bg-red-700">
                            Hapus
                        </button>
                    </div>
                    @endif
                </div>
            @empty
                <p class="text-center text-gray-500 col-span-full">Belum ada informasi.</p>
            @endforelse
        </div>
    </div>

    {{-- Modal Tambah/Edit --}}
    @if($isAdmin)
    <div id="formModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg w-full max-w-md p-6">
            <h2 id="formModalTitle" class="text-xl font-bold mb-4 text-center"></h2>
            <form id="formInformasi" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="formId">
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Judul</label>
                    <input type="text" name="judul" id="formJudul" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Informasi</label>
                    <textarea name="informasi" id="formIsi" class="w-full border rounded p-2" rows="4" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Foto</label>
                    <input type="file" name="foto" id="formFoto" class="w-full border p-2">
                    <img id="formPreview" src="#" alt="Preview" class="hidden mt-2 w-full h-40 object-cover rounded">
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeFormModal()"
                        class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Modal Detail --}}
    <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg w-full max-w-md p-6">
            <h2 id="detailTitle" class="text-xl font-bold mb-4 text-center"></h2>
            <img id="detailImage" src="#" class="w-full h-48 object-cover rounded mb-4">
            <p id="detailContent" class="text-gray-700"></p>
            <div class="text-right mt-4">
                <button onclick="closeDetailModal()"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tutup</button>
            </div>
        </div>
    </div>
</section>

<script>
    function showAddModal() {
        document.getElementById('formModalTitle').innerText = 'Tambah Informasi';
        document.getElementById('formInformasi').action = "{{ route('informasi.store') }}";
        document.getElementById('formJudul').value = '';
        document.getElementById('formIsi').value = '';
        document.getElementById('formFoto').value = '';
        document.getElementById('formPreview').classList.add('hidden');
        document.getElementById('formModal').classList.remove('hidden');
    }

    function showEditModal(id) {
        fetch(`/informasi/${id}/detail`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('formModalTitle').innerText = 'Edit Informasi';
                document.getElementById('formInformasi').action = `/informasi/${id}/update`;
                document.getElementById('formJudul').value = data.judul;
                document.getElementById('formIsi').value = data.informasi;
                document.getElementById('formId').value = id;

                if (data.foto) {
                    document.getElementById('formPreview').src = "{{ asset('storage/') }}/" + data.foto;
                    document.getElementById('formPreview').classList.remove('hidden');
                }

                document.getElementById('formModal').classList.remove('hidden');
            });
    }

    function closeFormModal() {
        document.getElementById('formModal').classList.add('hidden');
    }

    function showDetailModal(id) {
        fetch(`/informasi/${id}/detail`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('detailTitle').innerText = data.judul;
                document.getElementById('detailImage').src = "{{ asset('storage/') }}/" + data.foto;
                document.getElementById('detailContent').innerText = data.informasi;
                document.getElementById('detailModal').classList.remove('hidden');
            });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    function deleteInformasi(id) {
        if (confirm('Yakin ingin menghapus informasi ini?')) {
            fetch(`/informasi/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // reload untuk update tampilan
                } else {
                    alert('Gagal menghapus data.');
                }
            });
        }
    }


    document.getElementById('formFoto')?.addEventListener('change', function (e) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('formPreview');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(this.files[0]);
    });
</script>
@endsection
