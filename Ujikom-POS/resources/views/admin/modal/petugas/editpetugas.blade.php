<!-- Modal -->
<div class="modal fade" id="editpetugasModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Petugas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/admin/datapetugas/update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="hidden" class="form-control" id="id_editpetugas" name="id_editpetugas">
                                <input type="hidden" class="form-control" id="idUser_editpetugas" name="idUser_editpetugas">
                                <input type="text" class="form-control" id="kd_editpetugas" placeholder="ID Petugas" name="kd_editpetugas" required disabled>
                                <label for="kd_editpetugas">ID Petugas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="contact_editpetugas" placeholder="No. Telp" name="contact_editpetugas" required>
                                <label for="contact_editpetugas">No. Telp</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password_editpetugas" placeholder="Password" name="password_editpetugas" required>
                                <label for="password_editpetugas">Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nama_editpetugas" placeholder="Nama Petugas" name="nama_editpetugas" required disabled>
                                <label for="nama_editpetugas">Nama Lengkap</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" aria-label="Default select example" id="status_editpetugas"
                                    name="status_editpetugas" required disabled>
                                    <option selected>Pilih Status Petugas</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="non-aktif">Tidak Aktif</option>
                                </select>
                                <label for="status_editpetugas">Status Petugas</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" aria-label="Default select example" id="role_editpetugas"
                                    name="role_editpetugas" required>
                                    <option selected>Hak Akses Petugas</option>
                                    <option value="admin">Admin</option>
                                    <option value="kasir">Kasir</option>
                                </select>
                                <label for="role_editpetugas">Hak Akses Petugas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="posisi_editpetugas" placeholder="Posisi Petugas" name="posisi_editpetugas" required>
                                <label for="posisi_editpetugas">Posisi Petugas</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <div class="form-floating is-invalid">
                                    <input type="text" class="form-control" id="gaji_editpetugas"
                                        name="gaji_editpetugas" placeholder="100" required>
                                    <label for="gaji_editpetugas">Gaji Petugas</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Alamat Petugas" id="alamat_editpetugas" name="alamat_editpetugas"></textarea>
                                <label for="alamat_editpetugas">Alamat Petugas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="shift_editpetugas" name="shift_editpetugas" required>
                                    <option selected disabled>Pilih Jadwal Shift</option>
                                    @foreach ($shifts as $shift)
                                        <option value="{{ $shift['id_shifts'] }}">{{ $shift['nama_shifts'] }}</option>
                                    @endforeach
                                </select>
                                <label for="shift_editpetugas">Shift Petugas</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="waktushift_editpetugas" name="waktushift_editpetugas" disabled>
                                <label for="waktushift_editpetugas">Waktu Shift Petugas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label  class="form-label">Foto Petugas</label>
                                <div class="d-flex align-items-center">
                                    <img id="foto_preview" src="" alt="Foto Petugas" class="me-3" width="200">
                                    <input type="file" class="form-control" id="foto_editpetugas" name="foto_editpetugas">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editbutton_swal">Save changes</button>
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
    const gajiKaryawanInput = document.getElementById('gaji_editpetugas');

    [gajiKaryawanInput].forEach(input => {
        input.addEventListener('input', function (e) {
            const raw = unformatNumber(e.target.value);
            if (!isNaN(raw)) {
                e.target.value = formatNumber(raw);
            }
        });
    });

    $(document).ready(function() {
        $('#editpetugasModal').on('show.bs.modal', function(event) {
            var btn = $(event.relatedTarget),
                idpetugas = btn.data('idpetugas'),
                iduser = btn.data('iduser'),
                kodepetugas = btn.data('kodepetugas'),
                namapetugas = btn.data('namapetugas'),
                telppetugas = btn.data('telppetugas'),
                rolepetugas = btn.data('rolepetugas'),
                statuspetugas = btn.data('statuspetugas'),
                fotopetugas = btn.data('fotopetugas'),
                posisipetugas = btn.data('posisipetugas'),
                gajipetugas = btn.data('gajipetugas'),
                alamatpetugas = btn.data('alamatpetugas'),
                idshifts = btn.data('idshifts'),
                namashifts = btn.data('namashifts'),
                starttime = btn.data('starttime'),
                endtime = btn.data('endtime');

            $('#editpetugasModal').find('#id_editpetugas').val(idpetugas);
            $('#editpetugasModal').find('#idUser_editpetugas').val(iduser);
            $('#editpetugasModal').find('#kd_editpetugas').val(kodepetugas);
            $('#editpetugasModal').find('#contact_editpetugas').val(telppetugas);
            $('#editpetugasModal').find('#nama_editpetugas').val(namapetugas);
            $('#editpetugasModal').find('#status_editpetugas').val(statuspetugas);
            $('#editpetugasModal').find('#role_editpetugas').val(rolepetugas);
            $('#editpetugasModal').find('#posisi_editpetugas').val(posisipetugas);
            $('#editpetugasModal').find('#gaji_editpetugas').val(formatNumber(gajipetugas));
            $('#editpetugasModal').find('#alamat_editpetugas').val(alamatpetugas);
            $('#editpetugasModal').find('#shift_editpetugas').val(idshifts);
            $('#editpetugasModal').find('#foto_preview').attr('src', fotopetugas);
            $('#editbutton_swal').data('namapetugasswal', namapetugas);

            // Tambahkan ini:
            const selectedShift = shiftData.find(shift => shift.id_shifts == idshifts);
            if (selectedShift) {
                const start = selectedShift.start_time.slice(0, 5);
                const end = selectedShift.end_time.slice(0, 5);
                $('#waktushift_editpetugas').val(`${start} - ${end}`);
            } else {
                $('#waktushift_editpetugas').val('');
            }
        });

        // SweetAlert confirmation
        $('#editbutton_swal').click(function() {
        var current_object = $(this);

            Swal.fire({
                title: 'Yakin Untuk Mengubah Data ' + current_object.data('namapetugasswal') + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Ubah Data!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user menekan "Yes, delete it!", submit form
                    $('#gaji_editpetugas').val(unformatNumber($('#gaji_editpetugas').val()));
                    $('#editpetugasModal form').submit();
                }
            });
        });
    });
</script>
