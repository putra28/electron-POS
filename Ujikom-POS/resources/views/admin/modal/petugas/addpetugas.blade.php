<!-- Modal -->
<div class="modal fade" id="addpetugasModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Petugas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/admin/datapetugas/add') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="contact_addpetugas" placeholder="No. Telp" name="contact_addpetugas" required>
                                <label for="contact_addpetugas">No. Telp</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password_addpetugas" placeholder="Password" name="password_addpetugas" required>
                                <label for="password_addpetugas">Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nama_addpetugas" placeholder="Nama Petugas" name="nama_addpetugas" required>
                                <label for="nama_addpetugas">Nama Lengkap</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" aria-label="Default select example" id="status_addpetugas"
                                    name="status_addpetugas" required disabled>
                                    <option>Pilih Status Petugas</option>
                                    <option value="aktif" selected>Aktif</option>
                                    <option value="non-aktif">Tidak Aktif</option>
                                </select>
                                <label for="status_addpetugas">Status Petugas</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" aria-label="Default select example" id="role_addpetugas"
                                    name="role_addpetugas" required>
                                    <option selected>Hak Akses Petugas</option>
                                    <option value="admin">Admin</option>
                                    <option value="kasir">Kasir</option>
                                </select>
                                <label for="role_addpetugas">Hak Akses Petugas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="posisi_addpetugas" placeholder="Posisi Petugas" name="posisi_addpetugas" required>
                                <label for="posisi_addpetugas">Posisi Petugas</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <div class="form-floating is-invalid">
                                    <input type="text" class="form-control" id="gaji_addpetugas"
                                        name="gaji_addpetugas" placeholder="100" required>
                                    <label for="gaji_addpetugas">Gaji Petugas</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Alamat Petugas" id="alamat_addpetugas" name="alamat_addpetugas"></textarea>
                                <label for="alamat_addpetugas">Alamat Petugas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="shift_addpetugas" name="shift_addpetugas" required>
                                    <option selected disabled>Pilih Jadwal Shift</option>
                                    @foreach ($shifts as $shift)
                                        <option value="{{ $shift['id_shifts'] }}">{{ $shift['nama_shifts'] }}</option>
                                    @endforeach
                                </select>
                                <label for="shift_addpetugas">Shift Petugas</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="waktushift_addpetugas" name="waktushift_addpetugas" placeholder="Waktu Shift" disabled>
                                <label for="waktushift_addpetugas">Waktu Shift Petugas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label  class="form-label">Foto Petugas</label>
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control" id="foto_addpetugas" name="foto_addpetugas">
                                </div>
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
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function unformatNumber(num) {
        return num.toString().replace(/\./g, "");
    }

    // Formatting angka saat input
    const addgajiKaryawanInput = document.getElementById('gaji_addpetugas');

    [addgajiKaryawanInput].forEach(input => {
        input.addEventListener('input', function (e) {
            const raw = unformatNumber(e.target.value);
            if (!isNaN(raw)) {
                e.target.value = formatNumber(raw);
            }
        });
    });

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
                    $('#gaji_addpetugas').val(unformatNumber($('#gaji_addpetugas').val()));
                    $('#addpetugasModal form').submit();
                }
            });
        });
</script>
