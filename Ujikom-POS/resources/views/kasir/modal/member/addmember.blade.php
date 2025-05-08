<!-- Modal -->
<div class="modal fade" id="addmemberModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Member</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/kasir/datamember/add') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nama_addmember" placeholder="Nama Lengkap Member" name="nama_addmember" required>
                                <label for="nama_addmember">Nama Lengkap Member</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="tgllahir_addmember" placeholder="Tanggal Lahir Member" name="tgllahir_addmember" required>
                                <label for="tgllahir_addmember">Tanggal Lahir Member</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" aria-label="Default select example" id="gender_addmember" name="gender_addmember">
                                    <option>Pilih Gender Member</option>
                                    <option value="Laki-Laki">Laki - Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <label for="gender_addmember">Gender Member</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="telp_addmember" placeholder="No. Telp Member" name="telp_addmember" required>
                                <label for="telp_addmember">No. Telp Member</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email_addmember" placeholder="E-mail Member" name="email_addmember" required>
                                <label for="email_addmember">E-mail Member</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Alamat Member" id="alamat_addmember" name="alamat_addmember"></textarea>
                                <label for="alamat_addmember">Alamat Member</label>
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
                $('#addmemberModal form').submit();
            }
        });
    });
</script>
