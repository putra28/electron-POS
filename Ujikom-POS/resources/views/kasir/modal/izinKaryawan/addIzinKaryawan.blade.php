<!-- Modal -->
<div class="modal fade" id="addIzinModal" tabindex="-1" aria-labelledby="addIzinModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="addIzinModalLabel">Add Pengajuan Izin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/kasir/izinkaryawan/add') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="kategori_addIzin" name="kategori_addIzin" required>
                                    <option selected disabled>Pilih Jenis Perizinan</option>
                                    @foreach ($kategoriIzin as $kat)
                                        <option value="{{ $kat['id_kategori_izin'] }}">{{ $kat['nama_kategori_izin'] }}</option>
                                    @endforeach
                                </select>
                                <label for="kategori_addIzin">Kategori</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="startDate_addIzin" name="startDate_addIzin">
                                <label for="startDate_addIzin">Tanggal Mulai</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="endDate_addIzin" name="endDate_addIzin">
                                <label for="endDate_addIzin">Tanggal Selesai</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="addbutton_swal">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/jquery-3.7.1.min.js') }}"></script>
<script>
    $(document).ready(function () {
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
                    $('#addIzinModal form').submit();
                }
            });
        });
    });
</script>
