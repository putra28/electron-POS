<!-- Modal -->
<div class="modal fade" id="viewabsensiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="tgl_viewAbsensi" placeholder="Tanggal" name="tgl_viewAbsensi" required disabled>
                                <label for="tgl_viewAbsensi">Tanggal</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="clockIn_viewAbsensi" placeholder="Waktu Clock In" name="clockIn_viewAbsensi" required disabled>
                                <label for="clockIn_viewAbsensi">Waktu Clock In</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="clockOut_viewAbsensi" placeholder="Waktu Clock Out" name="clockOut_viewAbsensi" required disabled>
                                <label for="clockOut_viewAbsensi">Waktu Clock Out</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="totalJamKerja_viewAbsensi" placeholder="Total Jam Kerja" name="totalJamKerja_viewAbsensi" required disabled>
                                <label for="totalJamKerja_viewAbsensi">Total Jam Kerja</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="totalOvertime_viewAbsensi" placeholder="Total Overtime" name="totalOvertime_viewAbsensi" required disabled>
                                <label for="totalOvertime_viewAbsensi">Total Overtime</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="karyawan_viewAbsensi" placeholder="Nama Karyawan" name="karyawan_viewAbsensi" required disabled>
                                <label for="karyawan_viewAbsensi">Nama Karyawan</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="posisi_viewAbsensi" placeholder="Posisi Karyawan" name="posisi_viewAbsensi" required disabled>
                                <label for="posisi_viewAbsensi">Posisi Karyawan</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="shift_viewAbsensi" placeholder="Jadwal Shift" name="shift_viewAbsensi" required disabled>
                                <label for="shift_viewAbsensi">Jadwal Shift</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="waktuShift_viewAbsensi" placeholder="Waktu Shift" name="waktuShift_viewAbsensi" required disabled>
                                <label for="waktuShift_viewAbsensi">Waktu Shift</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/jquery-3.7.1.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#viewabsensiModal').on('show.bs.modal', function (event) {
            var btn = $(event.relatedTarget),
                idabsensi = btn.data('idabsensi'),
                tanggal = btn.data('tanggal'),
                waktuclockin = btn.data('waktuclockin'),
                waktuclockout = btn.data('waktuclockout'),
                totaljamkerja = btn.data('totaljamkerja'),
                totalovertime = btn.data('totalovertime'),
                namakaryawan = btn.data('namakaryawan'),
                posisikaryawan = btn.data('posisikaryawan'),
                namashift = btn.data('namashift'),
                starttime = btn.data('starttime'),
                endtime = btn.data('endtime');

            $('#viewabsensiModal').find('#tgl_viewAbsensi').val(tanggal);
            $('#viewabsensiModal').find('#clockIn_viewAbsensi').val(waktuclockin);
            $('#viewabsensiModal').find('#clockOut_viewAbsensi').val(waktuclockout);
            $('#viewabsensiModal').find('#totalJamKerja_viewAbsensi').val(totaljamkerja);
            $('#viewabsensiModal').find('#totalOvertime_viewAbsensi').val(totalovertime);
            $('#viewabsensiModal').find('#karyawan_viewAbsensi').val(namakaryawan);
            $('#viewabsensiModal').find('#posisi_viewAbsensi').val(posisikaryawan);
            $('#viewabsensiModal').find('#shift_viewAbsensi').val(namashift);

            const start = starttime.slice(0, 5);
            const end = endtime.slice(0, 5);
            $('#waktuShift_viewAbsensi').val(`${start} - ${end}`);
        });
    });
</script>
