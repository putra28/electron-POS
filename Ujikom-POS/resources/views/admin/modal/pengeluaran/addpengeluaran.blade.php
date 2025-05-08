<!-- Modal -->
<div class="modal fade" id="addpengeluaranModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Pengeluaran</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/admin/datapengeluaran/add') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="kategori_addPengeluaran" name="kategori_addPengeluaran" required>
                                    <option selected disabled>Pilih Jenis Pengeluaran</option>
                                    @foreach ($kategori_pengeluaran as $key => $kat)
                                        @if ($key != 0)
                                            <option value="{{ $kat['id_kategori_pengeluaran'] }}">{{ $kat['nama_kategori_pengeluaran'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <label for="kategori_addPengeluaran">Jenis Pengeluaran</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                              <span class="input-group-text">Rp.</span>
                              <div class="form-floating">
                                <input type="text" class="form-control" name="total_addPengeluaran" id="total_addPengeluaran" aria-describedby="basic-addon1" placeholder="Total Pengeluaran" required>
                                <label for="floatingInputGroup1">Total Pengeluaran</label>
                              </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="tanggal_addPengeluaran" placeholder="Tanggal Pengeluaran" name="tanggal_addPengeluaran" value="{{ date('Y-m-d') }}" required>
                                <label for="tanggal_addPengeluaran">Tanggal Pengeluaran</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Deskripsi Pengeluaran" id="deskripsi_addPengeluaran" name="deskripsi_addPengeluaran"></textarea>
                                <label for="deskripsi_addPengeluaran">Deskripsi Pengeluaran</label>
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
        return num.toString().replace(/\./g, "").replace(/[^0-9]/g, "");
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Format dan hitung harga diskon otomatis saat user input
        const totalAddPengeluaran = document.getElementById('total_addPengeluaran');

        totalAddPengeluaran.addEventListener('input', function () {
            const unformatted = unformatNumber(this.value);
            this.value = formatNumber(unformatted);
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
                $('#total_addPengeluaran').val(unformatNumber($('#total_addPengeluaran').val()));
                // Jika user menekan "Yes, delete it!", submit form
                $('#addpengeluaranModal form').submit();
            }
        });
    });
</script>
