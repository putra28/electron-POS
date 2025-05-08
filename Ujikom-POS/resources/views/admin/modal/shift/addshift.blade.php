<!-- Modal -->
<div class="modal fade" id="addshiftModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Jadwal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/admin/datashift/add') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="jadwal_addshift" placeholder="Nama Lengkap Member" name="jadwal_addshift" required>
                                <label for="jadwal_addshift">Jadwal Shift</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="time" class="form-control" id="startTime_addshift" placeholder="Tanggal Lahir Member" name="startTime_addshift" required>
                                <label for="startTime_addshift">Start Time</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="time" class="form-control" id="endTime_addshift" placeholder="Tanggal Lahir Member" name="endTime_addshift" required>
                                <label for="endTime_addshift">End Time</label>
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
                $('#addshiftModal form').submit();
            }
        });
    });
</script>
