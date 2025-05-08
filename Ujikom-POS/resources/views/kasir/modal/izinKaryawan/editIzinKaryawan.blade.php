<!-- Modal -->
<div class="modal fade" id="editIzinModal" tabindex="-1" aria-labelledby="editIzinModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="editIzinModalLabel">Edit Izin Karyawan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/kasir/izinkaryawan/update') }}" method="POST">
                    @csrf
                    <input type="hidden" id="idIzin_editIzin" name="idIzin_editIzin">


                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="tglPengajuan_editIzin" name="tglPengajuan_editIzin" disabled>
                                <label for="tglPengajuan_editIzin">Tanggal Pengajuan</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="kategoriIzin_editIzin" name="kategoriIzin_editIzin" disabled>
                                <label for="kategoriIzin_editIzin">Kategori Izin</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="namaKaryawan_editIzin" name="namaKaryawan_editIzin" disabled>
                                <label for="namaKaryawan_editIzin">Nama Karyawan</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="posisiKaryawan_editIzin" name="posisiKaryawan_editIzin" disabled>
                                <label for="posisiKaryawan_editIzin">Posisi Karyawan</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="startDate_editIzin" name="startDate_editIzin">
                                <label for="startDate_editIzin">Tanggal Mulai</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="endDate_editIzin" name="endDate_editIzin">
                                <label for="endDate_editIzin">Tanggal Selesai</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="statusIzin_editIzin" name="statusIzin_editIzin" readonly>
                                <label for="statusIzin_editIzin">Status</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" id="cancelizin_swal">Cancel Pengajuan</button>
                <button type="button" class="btn btn-primary" id="editizin_swal">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/jquery-3.7.1.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#editIzinModal').on('show.bs.modal', function (event) {
            var btn = $(event.relatedTarget);

            $('#idIzin_editIzin').val(btn.data('idizin'));
            $('#tglPengajuan_editIzin').val(btn.data('tanggal'));
            $('#namaKaryawan_editIzin').val(btn.data('namakaryawan'));
            $('#posisiKaryawan_editIzin').val(btn.data('posisikaryawan'));
            $('#kategoriIzin_editIzin').val(btn.data('jenisizin'));
            $('#startDate_editIzin').val(btn.data('startdate').split('-').reverse().join('-'));
            $('#endDate_editIzin').val(btn.data('enddate').split('-').reverse().join('-'));
            $('#statusIzin_editIzin').val(btn.data('status'));
            $('#editizin_swal').data('namakaryawan', btn.data('namakaryawan'));
        });

        $('#editizin_swal').click(function () {
            var current_object = $(this);
            Swal.fire({
                title: 'Yakin ingin mengubah status izin ' + current_object.data('namakaryawan') + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Ubah!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#editIzinModal form').submit();
                }
            });
        });

        $('#cancelizin_swal').click(function () {
            var current_object = $(this);
            Swal.fire({
                title: 'Yakin ingin membatalkan izin ' + $('#namaKaryawan_editIzin').val() + '?',
                text: "Status akan diubah menjadi 'Canceled'.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Batalkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#statusIzin_editIzin').val('Canceled'); // ubah status
                    $('#editIzinModal form').submit(); // kirim form
                }
            });
        });
    });
</script>
