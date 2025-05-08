<!-- Modal -->
<div class="modal fade" id="viewpenjualanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">View Penjualan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="datetime" class="form-control" id="tgl_viewtransaksi"
                                    placeholder="Tanggal dan Waktu" name="tgl_viewtransaksi" readonly>
                                <label for="tgl_viewtransaksi">Tanggal dan Waktu</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="hidden" class="form-control" id="id_viewtransaksi" readonly>
                                <input type="text" class="form-control" id="no_viewtransaksi"
                                    placeholder="No. Transaksi" name="no_viewtransaksi" readonly>
                                <label for="no_viewtransaksi">No. Transaksi</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="status_viewtransaksi"
                                    placeholder="Status Transaksi" name="status_viewtransaksi" readonly>
                                <label for="status_viewtransaksi">Status Transaksi</label>
                            </div>
                        </div>
                    </div><div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="total_viewtransaksi"
                                        placeholder="Total Transaksi" name="total_viewtransaksi" readonly>
                                    <label for="total_viewtransaksi">Total Transaksi</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="totbay_viewtransaksi"
                                        placeholder="Total Bayar" name="totbay_viewtransaksi" readonly>
                                    <label for="totbay_viewtransaksi">Total Bayar</label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="kembalian_viewtransaksi"
                                        placeholder="Kembalian Transaksi" name="kembalian_viewtransaksi" readonly>
                                    <label for="kembalian_viewtransaksi">Kembalian Transaksi</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="petugas_viewtransaksi"
                                    placeholder="Kasir" name="petugas_viewtransaksi" readonly>
                                <label for="petugas_viewtransaksi">Kasir</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="member_viewtransaksi"
                                    placeholder="Member" name="member_viewtransaksi" readonly>
                                <label for="member_viewtransaksi">Member</label>
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
                                        <th>Stok Produk</th>
                                        <th>Harga Produk</th>
                                        <th>Diskon Produk</th>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        $('#viewpenjualanModal').on('show.bs.modal', function(event) {
            var btn = $(event.relatedTarget),
                idtransaksi = btn.data('idtransaksi'),
                notransaksi = btn.data('notransaksi'),
                namapetugas = btn.data('namapetugas'),
                tgltransaksi = btn.data('tgltransaksi'),
                namamember = btn.data('namamember'),
                kembaliantransaksi = btn.data('kembaliantransaksi'),
                totaltransaksi = btn.data('totaltransaksi'),
                totalbayar = btn.data('totalbayar'),
                statustransaksi = btn.data('statustransaksi'),
                detail = btn.data('detail');

            $('#viewpenjualanModal').find('#id_viewtransaksi').val(idtransaksi);
            $('#viewpenjualanModal').find('#no_viewtransaksi').val(notransaksi);
            $('#viewpenjualanModal').find('#petugas_viewtransaksi').val(namapetugas);
            $('#viewpenjualanModal').find('#tgl_viewtransaksi').val(tgltransaksi);
            $('#viewpenjualanModal').find('#member_viewtransaksi').val(namamember);
            $('#viewpenjualanModal').find('#totbay_viewtransaksi').val(totalbayar);
            $('#viewpenjualanModal').find('#kembalian_viewtransaksi').val(kembaliantransaksi);
            $('#viewpenjualanModal').find('#total_viewtransaksi').val(totaltransaksi);
            $('#viewpenjualanModal').find('#status_viewtransaksi').val(statustransaksi);
            // Bersihkan data barang sebelumnya
            $('#product-details').empty();

            // Tampilkan data barang pada modal
            detail.forEach(item => {
                var row = `
                    <tr>
                        <td>${item.produk.nama_produk}</td>
                        <td>${item.kuantitas}</td>
                        <td>Rp. ${formatRupiah(item.harga)}</td>
                        <td>${item.diskon_produk}</td>
                    </tr>
                `;
                $('#product-details').append(row);
            });
        });
    });
</script>
<script>
    // Fungsi untuk mencetak nota
    function printNota() {
        // Mendapatkan nilai dari setiap elemen input pada modal
        var tglTransaksi = document.getElementById('tgl_viewtransaksi').value;
        var noTransaksi = document.getElementById('no_viewtransaksi').value;
        var statusTransaksi = document.getElementById('status_viewtransaksi').value;
        var totalTransaksi = document.getElementById('total_viewtransaksi').value;
        var totalBayar = document.getElementById('totbay_viewtransaksi').value;
        var kembalianTransaksi = document.getElementById('kembalian_viewtransaksi').value;
        var petugas = document.getElementById('petugas_viewtransaksi').value;
        var member = document.getElementById('member_viewtransaksi').value;
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
