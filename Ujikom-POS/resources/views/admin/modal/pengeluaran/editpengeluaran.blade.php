<!-- Modal -->
<div class="modal fade" id="editpengeluaranModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pengeluaran</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/admin/datapengeluaran/update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                    <input type="hidden" class="form-control" id="id_editPengeluaran" placeholder="Total Pengeluaran" name="id_editPengeluaran" required>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="kategori_editPengeluaran" name="kategori_editPengeluaran" required>
                                    <option selected disabled>Pilih Jenis Kategori</option>
                                    @foreach ($kategori_pengeluaran as $kat)
                                        <option value="{{ $kat['id_kategori_pengeluaran'] }}">{{ $kat['nama_kategori_pengeluaran'] }}</option>
                                    @endforeach
                                </select>
                                <label for="kategori_editPengeluaran">Jenis Pengeluaran</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                              <span class="input-group-text">Rp.</span>
                              <div class="form-floating">
                                <input type="text" class="form-control" name="total_editPengeluaran" id="total_editPengeluaran" readonly>
                                <label for="floatingInputGroup1">Total Pengeluaran</label>
                              </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="tanggal_editPengeluaran" placeholder="Tanggal Pengeluaran" name="tanggal_editPengeluaran" value="{{ date('Y-m-d') }}" required>
                                <label for="tanggal_editPengeluaran">Tanggal Pengeluaran</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Deskripsi Pengeluaran" id="deskripsi_editPengeluaran" name="deskripsi_editPengeluaran" style="height: 150px;"></textarea>
                                <label for="deskripsi_editPengeluaran">Deskripsi Pengeluaran</label>
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
        return num.toString().replace(/\./g, "").replace(/[^0-9]/g, "");
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Format dan hitung harga diskon otomatis saat user input
        const totalEditPengeluaran = document.getElementById('total_editPengeluaran');

        totalEditPengeluaran.addEventListener('input', function () {
            const unformatted = unformatNumber(this.value);
            this.value = formatNumber(unformatted);
        });
    });

    $(document).ready(function() {
        $('#editpengeluaranModal').on('show.bs.modal', function(event) {
            var btn = $(event.relatedTarget),
                idpengeluaran = btn.data('idpengeluaran'),
                nopengeluaran = btn.data('nopengeluaran'),
                idkategoripengeluaran = btn.data('idkategoripengeluaran'),
                namakategoripengeluaran = btn.data('namakategoripengeluaran'),
                nopengeluaran = btn.data('nopengeluaran'),
                totalhargapengeluaran = btn.data('totalhargapengeluaran'),
                deskripsipengeluaran = btn.data('deskripsipengeluaran'),
                tglpengeluaran = btn.data('tglpengeluaran');

            $('#editpengeluaranModal').find('#id_editPengeluaran').val(idpengeluaran);
            $('#editpengeluaranModal').find('#kategori_editPengeluaran').val(idkategoripengeluaran);
            $('#editpengeluaranModal').find('#total_editPengeluaran').val(totalhargapengeluaran);
            $('#editpengeluaranModal').find('#tanggal_editPengeluaran').val(tglpengeluaran.substring(0, 10));
            $('#editpengeluaranModal').find('#deskripsi_editPengeluaran').val(deskripsipengeluaran);
            $('#editbutton_swal').data('nopengeluaranswal', nopengeluaran);

            // 🔒 Disable semua input dan sembunyikan tombol jika kategori = 1
            if (idkategoripengeluaran == 1) {
                $('#editpengeluaranModal').find('input, select, textarea').prop('disabled', true);
                $('#editbutton_swal').hide();
            } else {
                $('#editpengeluaranModal').find('input, select, textarea').prop('disabled', false);
                $('#editbutton_swal').show();
            }
        });

        // SweetAlert confirmation
        $('#editbutton_swal').click(function() {
        var current_object = $(this);

            Swal.fire({
                title: 'Yakin Untuk Mengubah Data ' + current_object.data('nopengeluaranswal') + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Ubah Data!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#total_editPengeluaran').val(unformatNumber($('#total_editPengeluaran').val()));
                    // Jika user menekan "Yes, delete it!", submit form
                    $('#editpengeluaranModal form').submit();
                }
            });
        });
    });
</script>
