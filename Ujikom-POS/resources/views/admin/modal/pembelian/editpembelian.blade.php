<!-- Modal -->
<div class="modal fade" id="editpembelianModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">View Penjualan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/admin/datapembelian/update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="datetime" class="form-control" id="tgl_editpembelian"
                                    placeholder="Tanggal dan Waktu" name="tgl_editpembelian" readonly>
                                <label for="tgl_editpembelian">Tanggal dan Waktu</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="hidden" class="form-control" name="id_editpembelian" id="id_editpembelian">
                                <input type="text" class="form-control" id="no_editpembelian"
                                    placeholder="No. Transaksi" name="no_editpembelian" readonly>
                                <label for="no_editpembelian">No. Pembelian</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="total_editpembelian"
                                        placeholder="Total Transaksi" name="total_editpembelian" readonly>
                                    <label for="total_editpembelian">Total Harga</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="supplier_editpembelian"
                                        placeholder="Total Bayar" name="supplier_editpembelian" readonly>
                                    <label for="supplier_editpembelian">Supplier</label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="updated_editpembelian"
                                        placeholder="Kembalian Transaksi" name="updated_editpembelian" readonly>
                                    <label for="updated_editpembelian">Updated Status at</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5>Detail Produk</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Harga Modal</th>
                                        <th>Kuantitas</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody id="product-details"></tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnPrint">Cetak</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editbutton_swal">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/jquery-3.7.1.min.js') }}"></script>
<script>
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 0
        }).format(angka);
    }

    $(document).ready(function() {
        $('#editpembelianModal').on('show.bs.modal', function(event) {
            var btn = $(event.relatedTarget),
                idpembelian = btn.data('idpembelian'),
                nopembelian = btn.data('nopembelian'),
                totalHargapembelian = btn.data('totalhargapembelian'),
                tglpembelian = btn.data('tglpembelian'),
                supplier = btn.data('supplier'),
                updatedat = btn.data('updatedat'),
                detail = btn.data('detail');

            $('#editpembelianModal').find('#id_editpembelian').val(idpembelian);
            $('#editpembelianModal').find('#no_editpembelian').val(nopembelian);
            $('#editpembelianModal').find('#tgl_editpembelian').val(tglpembelian);
            $('#editpembelianModal').find('#total_editpembelian').val(totalHargapembelian);
            $('#editpembelianModal').find('#supplier_editpembelian').val(supplier);
            $('#editpembelianModal').find('#updated_editpembelian').val(updatedat);
            $('#editbutton_swal').data('kodepembelianswal', nopembelian);
            // Bersihkan data barang sebelumnya
            $('#product-details').empty();

            // Tampilkan data barang pada modal
            detail.forEach(item => {
                var row = `
                    <tr>
                        <td>${item.produk.nama_produk}</td>
                        <td>Rp. ${formatRupiah(item.produk.modal_produk)}</td>
                        <td>${item.kuantitas}</td>
                        <td>Rp. ${formatRupiah(item.subtotal)}</td>
                    </tr>
                `;
                $('#product-details').append(row);
            });
        });

        // SweetAlert
        $('#editbutton_swal').click(function () {
            const current_object = $(this);
            Swal.fire({
                title: 'Yakin Untuk Mengubah Data ' + current_object.data('kodepembelianswal') + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Ubah Data!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#editpembelianModal form').submit();
                }
            });
        });
    });
</script>
<script>
    // Fungsi untuk mencetak nota
    function printNota() {
        // Mendapatkan nilai dari setiap elemen input pada modal
        var tglTransaksi = document.getElementById('tgl_editpembelian').value;
        var noTransaksi = document.getElementById('no_editpembelian').value;
        var statusTransaksi = document.getElementById('status_editpembelian').value;
        var totalTransaksi = document.getElementById('total_editpembelian').value;
        var totalBayar = document.getElementById('totbay_editpembelian').value;
        var kembalianTransaksi = document.getElementById('kembalian_editpembelian').value;
        var petugas = document.getElementById('petugas_editpembelian').value;
        var member = document.getElementById('member_editpembelian').value;
        // Mendapatkan detail produk dari tabel
        var productRows = document.getElementById('product-details').getElementsByTagName('tr');
        var productsHTML = '';
        for (var i = 0; i < productRows.length; i++) {
            var cells = productRows[i].getElementsByTagName('td');
            var productName = cells[0].innerText;
            var productStock = cells[1].innerText;
            var productPrice = cells[2].innerText;
            var productDiscount = cells[3].innerText;
            productsHTML += '<tr><td>' + productName + '</td><td>' + productStock + '</td><td>' + productPrice + '</td><td>' + productDiscount + '</td></tr>';
        }

        // Membuat halaman baru untuk pencetakan
        var printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Cetak Nota ' + noTransaksi + '</title>');
        printWindow.document.write('<style>');
        printWindow.document.write(`
            body {
                font-family: Arial, sans-serif;
                padding: 20px;
                text-align: center;
            }
            .nota-container {
                max-width: 350px;
                margin: 0 auto;
                border: 1px solid #000;
                padding: 15px;
            }
            h2, h3 {
                margin: 10px 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 10px 0;
            }
            table th, table td {
                border: 1px solid #000;
                padding: 4px;
                font-size: 12px;
                text-align: left;
            }
            table th {
                background-color: #f0f0f0;
            }
            .info-table td {
                border: none;
                padding: 2px 0;
            }
        `);

        printWindow.document.write('</style>');
        printWindow.document.write('</head><body onload="print()">');
        printWindow.document.write('<div class="nota-container">');
        printWindow.document.write('<h2>Nota Pembelian</h2>');
        printWindow.document.write('<table class="info-table">');
        printWindow.document.write('<tr><td>Tanggal:</td><td>' + tglTransaksi + '</td></tr>');
        printWindow.document.write('<tr><td>No. Transaksi:</td><td>' + noTransaksi + '</td></tr>');
        printWindow.document.write('<tr><td>Status:</td><td>' + statusTransaksi + '</td></tr>');
        printWindow.document.write('<tr><td>Kasir:</td><td>' + petugas + '</td></tr>');
        printWindow.document.write('<tr><td>Member:</td><td>' + member + '</td></tr>');
        printWindow.document.write('</table>');
        printWindow.document.write('<h3>Detail Produk</h3>');
        printWindow.document.write('<table>');
        printWindow.document.write('<tr><th>Nama</th><th>Qty</th><th>Harga</th><th>Diskon</th></tr>');
        printWindow.document.write(productsHTML);
        printWindow.document.write('</table>');
        printWindow.document.write('<table class="info-table">');
        printWindow.document.write('<tr><td><strong>Total:</strong></td><td>' + totalTransaksi + '</td></tr>');
        printWindow.document.write('<tr><td><strong>Bayar:</strong></td><td>' + totalBayar + '</td></tr>');
        printWindow.document.write('<tr><td><strong>Kembalian:</strong></td><td>' + kembalianTransaksi + '</td></tr>');
        printWindow.document.write('</table>');
        printWindow.document.write('<p>Terima kasih atas kunjungannya!</p>');
        printWindow.document.write('</div>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
    }
        // Menambahkan event listener untuk tombol cetak
        document.getElementById('btnPrint').addEventListener('click', printNota);
</script>
