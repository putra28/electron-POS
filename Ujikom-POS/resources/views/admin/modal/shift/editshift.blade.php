<!-- Modal -->
<div class="modal fade" id="editShiftModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Jadwal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/admin/datashift/update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="hidden" class="form-control" id="id_editshift" name="id_editshift">
                                <input type="text" class="form-control" id="jadwal_editshift" placeholder="Nama Lengkap Member" name="jadwal_editshift" required>
                                <label for="jadwal_editshift">Jadwal Shift</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="time" class="form-control" id="startTime_editshift" placeholder="Tanggal Lahir Member" name="startTime_editshift" required>
                                <label for="startTime_editshift">Start Time</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="time" class="form-control" id="endTime_editshift" placeholder="Tanggal Lahir Member" name="endTime_editshift" required>
                                <label for="endTime_editshift">End Time</label>
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
        $('#editShiftModal').on('show.bs.modal', function(event) {
            var btn = $(event.relatedTarget),
                idShift = btn.data('idshift'),
                namaShift = btn.data('namashift'),
                startTime = btn.data('starttime'),
                endTime = btn.data('endtime');

            $('#editShiftModal').find('#id_editshift').val(idShift);
            $('#editShiftModal').find('#jadwal_editshift').val(namaShift);
            $('#editShiftModal').find('#startTime_editshift').val(startTime);
            $('#editShiftModal').find('#endTime_editshift').val(endTime);
            $('#editbutton_swal').data('namaShiftswal', namaShift);
        });

        // SweetAlert confirmation
        $('#editbutton_swal').click(function() {
        var current_object = $(this);

            Swal.fire({
                title: 'Yakin Untuk Mengubah Data ' + current_object.data('namaShiftswal') + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Ubah Data!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user menekan "Yes, delete it!", submit form
                    $('#editShiftModal form').submit();
                }
            });
        });
    });
</script>
