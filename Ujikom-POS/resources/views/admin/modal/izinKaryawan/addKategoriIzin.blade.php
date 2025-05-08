<!-- Modal -->
<div class="modal fade" id="addizinModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Kategori Izin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/admin/dataizinkaryawan/addJenisPerizinan') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="kategoriIzin_addIzin" placeholder="Nama Lengkap Member" name="kategoriIzin_addIzin" required>
                                <label for="kategoriIzin_addIzin">Nama Jenis Perizinan</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <table class="table table-bordered" id="subKategoriTable_addKategoriIzin">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No. </th>
                                            <th>Nama Jenis Perizinan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($kategoriIzin as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item['nama_kategori_izin'] }}</td>
                                            <td>
                                                <button class="btn btn-danger w-100 deleteSwal"
                                                    data-idKategori="{{ $item['id_kategori_izin'] }}"
                                                    data-namaKategori="{{ $item['nama_kategori_izin'] }}"
                                                    data-action="{{ route('admin.dataizin.deleteKategoriIzin', $item['nama_kategori_izin']) }}">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Belum ada data kategori izin</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addbutton_swal">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/jquery-3.7.1.min.js') }}"></script>
<script>
    // SweetAlert confirmation
    $('#addbutton_swal').click(function() {
        Swal.fire({
            title: 'Yakin Untuk Menambah Data?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Tambah Data!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user menekan "Yes, delete it!", submit form
                $('#addizinModal form').submit();
            }
        });
    });
</script>
