<!-- Modal -->
<div class="modal fade" id="editsupplierModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Petugas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/admin/datasupplier/update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                    <input type="hidden" class="form-control" id="id_editSupplier" name="id_editSupplier" required>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nama_editSupplier" placeholder="Nama supplier" name="nama_editSupplier" required>
                                <label for="nama_editSupplier">Nama supplier</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="contactPerson_editSupplier" placeholder="Contact Person" name="contactPerson_editSupplier" required>
                                <label for="contactPerson_editSupplier">Contact Person</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="contactSuppliers_editSupplier" placeholder="Contact Supplier" name="contactSuppliers_editSupplier" required>
                                <label for="contactSuppliers_editSupplier">Contact Supplier</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email_editSupplier" placeholder="Email Supplier" name="email_editSupplier" required>
                                <label for="email_editSupplier">Email Supplier</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Alamat supplier" id="alamat_editSupplier" name="alamat_editSupplier" required style="height: 150px"></textarea>
                                <label for="alamat_editSupplier">Alamat supplier</label>
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
    $(document).ready(function() {
        $('#editsupplierModal').on('show.bs.modal', function (event) {
            var btn = $(event.relatedTarget),
                idsupplier = btn.data('idsupplier'),
                namasupplier = btn.data('namasupplier'),
                contactperson = btn.data('contactperson'),
                contactsupplier = btn.data('contactsupplier'),
                emailsupplier = btn.data('emailsupplier'),
                alamatsupplier = btn.data('alamatsupplier');

            $('#editsupplierModal').find('#id_editSupplier').val(idsupplier);
            $('#editsupplierModal').find('#nama_editSupplier').val(namasupplier);
            $('#editsupplierModal').find('#contactPerson_editSupplier').val(contactperson);
            $('#editsupplierModal').find('#contactSuppliers_editSupplier').val(contactsupplier);
            $('#editsupplierModal').find('#email_editSupplier').val(emailsupplier);
            $('#editsupplierModal').find('#alamat_editSupplier').val(alamatsupplier);
            $('#editbutton_swal').data('namasupplierswal', namasupplier);
        });

        // SweetAlert
        $('#editbutton_swal').click(function () {
            const current_object = $(this);
            Swal.fire({
                title: 'Yakin Untuk Mengubah Data ' + current_object.data('namasupplierswal') + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Ubah Data!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#editsupplierModal form').submit();
                }
            });
        });
    });
</script>
