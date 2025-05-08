<!-- Modal -->
<div class="modal fade" id="addsupplierModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Petugas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/admin/datasupplier/add') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nama_addsupplier" placeholder="Nama supplier" name="nama_addsupplier" required>
                                <label for="nama_addsupplier">Nama supplier</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="contactPerson_addsupplier" placeholder="Contact Person" name="contactPerson_addsupplier" required>
                                <label for="contactPerson_addsupplier">Contact Person</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="contactSuppliers_addsupplier" placeholder="Contact Supplier" name="contactSuppliers_addsupplier" required>
                                <label for="contactSuppliers_addsupplier">Contact Supplier</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email_addsupplier" placeholder="Email Supplier" name="email_addsupplier" required>
                                <label for="email_addsupplier">Email Supplier</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Alamat supplier" id="alamat_addsupplier" name="alamat_addsupplier" required style="height: 150px"></textarea>
                                <label for="alamat_addsupplier">Alamat supplier</label>
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
                    $('#addsupplierModal form').submit();
                }
            });
        });
</script>
