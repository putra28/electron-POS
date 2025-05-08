<!-- Modal -->
<div class="modal fade" id="addkategoriModal" tabindex="-1" aria-labelledby="addkategoriLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="addkategoriLabel">Add Kategori Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/admin/datakategori/add') }}" method="POST"
                enctype="multipart/form-data" id="form_addKategoriProduk">
                @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="namaKategori_addKategoriProduk" name="namaKategori_addKategoriProduk" placeholder="Nama Kategori" required>
                        <label for="namaKategori_addKategoriProduk">Nama Kategori</label>
                    </div>

                    <div class="mb-3">
                        <table class="table table-bordered" id="subKategoriTable_addKategoriProduk">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama Sub Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2" style="width: 100%; text-align: center;">
                                        <button type="button" class="btn btn-sm btn-success mb-2" id="addRowBtn_addKategoriProduk" style="width: 100%;">+ Add Sub Kategori</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitForm_addKategoriProduk">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/jquery-3.7.1.min.js') }}"></script>
<script>
    $(document).ready(function () {
        // Menambah row input sub kategori
        $('#addRowBtn_addKategoriProduk').click(function () {
            $('#subKategoriTable_addKategoriProduk tbody').append(`
                <tr>
                    <td><input type="text" class="form-control" name="subKategori_addKategoriProduk[]" placeholder="Nama Sub Kategori" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm w-100 removeRowBtn">Hapus</button></td>
                </tr>
            `);
        });

        // Menghapus row
        $('#subKategoriTable_addKategoriProduk').on('click', '.removeRowBtn', function () {
            $(this).closest('tr').remove();
        });

        // Submit form
        $('#submitForm_addKategoriProduk').click(function () {
            Swal.fire({
                title: 'Yakin Untuk Menambah Data?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Tambah Data!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_addKategoriProduk').submit();
                }
            });
        });
    });
</script>

