<!-- Modal -->
<div class="modal fade" id="editkategoriModal" tabindex="-1" aria-labelledby="editkategoriLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="editkategoriLabel">Edit Kategori Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/admin/datakategori/update') }}" method="POST" enctype="multipart/form-data" id="form_editKategoriProduk">
                    @csrf
                    <input type="hidden" id="idKategori_editKategoriProduk" name="idKategori_editKategoriProduk">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="namaKategori_editKategoriProduk" name="namaKategori_editKategoriProduk" placeholder="Nama Kategori" required>
                        <label for="namaKategori_editKategoriProduk">Nama Kategori</label>
                    </div>

                    <div class="mb-3">
                        <table class="table table-bordered" id="subKategoriTable_editKategoriProduk">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama Sub Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Subkategori akan diisi lewat JS -->
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-sm btn-success w-100 mb-2" id="addRowBtn_editKategoriProduk">+ Add Sub Kategori</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitForm_editKategoriProduk">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/jquery-3.7.1.min.js') }}"></script>
<script>
    $(document).ready(function () {
        // Show modal edit dan isi field
        $('#editkategoriModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const idKategori = button.data('idkategori');
            const namaKategori = button.data('namakategori');
            const subKategoris = button.data('subkategori'); // array of object

            const modal = $(this);
            modal.find('#idKategori_editKategoriProduk').val(idKategori);
            modal.find('#namaKategori_editKategoriProduk').val(namaKategori);

            const tableBody = modal.find('#subKategoriTable_editKategoriProduk tbody');
            tableBody.empty(); // Kosongkan isi tabel dulu

            if (Array.isArray(subKategoris)) {
                subKategoris.forEach(item => {
                    tableBody.append(`
                        <tr>
                            <td>
                                <input type="hidden" name="edit_idsubKategoriProduk[]" class="form-control" value="${item.id_subkategori}" required>
                                <input type="text" name="edit_subKategoriProduk[]" class="form-control" value="${item.nama_subkategori}" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm w-100 removeRowBtn">Hapus</button>
                            </td>
                        </tr>
                    `);
                });
            } else {
                tableBody.append(`
                    <tr>
                        <td colspan="2" style="text-align: center;">Belum ada sub kategori</td>
                    </tr>
                `);
            }
        });

        // Tambah row subkategori di edit
        $('#addRowBtn_editKategoriProduk').click(function () {
            $('#subKategoriTable_editKategoriProduk tbody').append(`
                <tr>
                    <td><input type="text" name="subKategori_editKategoriProduk[]" class="form-control" placeholder="Nama Sub Kategori" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm w-100 removeRowBtn">Hapus</button></td>
                </tr>
            `);
        });

        // Hapus row subkategori
        $('#subKategoriTable_editKategoriProduk').on('click', '.removeRowBtn', function () {
        const row = $(this).closest('tr');
        const idSubkategoriInput = row.find('input[name="edit_idsubKategoriProduk[]"]');
        const idSubkategori = idSubkategoriInput.val();
        const idKategori = $('#idKategori_editKategoriProduk').val();

        // Jika row memiliki input id_subkategori, berarti ini data lama => tampilkan Swal
        if (idSubkategori) {
            Swal.fire({
                title: 'Yakin Untuk Menghapus Subkategori Ini?',
                icon: 'warning',
                iconColor: 'red',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim DELETE ke API
                    $.ajax({
                        url: `http://localhost:1111/api/kategori/${idKategori}/subkategori/${idSubkategori}`,
                        type: 'DELETE',
                        success: function (response) {
                            Swal.fire('Sukses!', 'Subkategori berhasil dihapus.', 'success');
                            row.remove(); // Hapus baris dari tabel
                        },
                        error: function () {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
                        }
                    });
                }
            });
        } else {
            // Jika tidak ada ID subkategori => data baru, cukup hapus baris
            row.remove();
        }
    });

        // Submit form edit
        $('#submitForm_editKategoriProduk').click(function () {
            Swal.fire({
                title: 'Yakin Untuk Menyimpan Perubahan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Simpan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_editKategoriProduk').submit();
                }
            });
        });
    });
</script>
