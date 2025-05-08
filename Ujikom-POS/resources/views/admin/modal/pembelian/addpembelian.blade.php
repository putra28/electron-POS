<!-- Modal -->
<div class="modal fade" id="addpembelianModal" tabindex="-1" aria-labelledby="addPembelianLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h1 class="modal-title fs-5" id="addPembelianLabel">Tambah Pembelian</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

      <div class="modal-body">
        <form id="form_addPembelian">
          @csrf
          <div class="mb-3">
            <label for="supplier" class="form-label">Supplier</label>
            <select class="form-select" id="supplier" name="p_idSuppliers" required>
              <option value="">Pilih Supplier</option>
              @foreach($supplier as $s)
                <option value="{{ $s['id_suppliers'] }}">{{ $s['nama_suppliers'] }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Pembelian</label>
            <input type="date" class="form-control" name="p_tanggal" id="tanggal" value="{{ now()->format('Y-m-d') }}" required>
          </div>
          <div class="mb-3">
            <label>Detail Produk</label>
            <table class="table table-bordered" id="detailPembelianTable">
              <thead class="table-dark">
                <tr>
                  <th>Produk</th>
                  <th>Kuantitas</th>
                  <th>Harga Modal</th>
                  <th>Subtotal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="5" class="text-center">
                    <button type="button" class="btn btn-success btn-sm w-100" id="addProdukRow">+ Tambah Produk</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <label for="totalHarga" class="form-label">Total Harga</label>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">Rp.</span>
              <input type="text" class="form-control" name="p_totalHarga" id="totalHarga" readonly data-raw="0">
            </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="submitPembelian">Simpan</button>
      </div>
    </div>
  </div>
</div>
<script>
  const produkList = @json($produk);

  function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  function unformatNumber(str) {
    return parseFloat(str.replace(/\./g, ""));
  }

  function hitungTotal() {
    let total = 0;
    $('#detailPembelianTable tbody tr').each(function () {
      const rawSubtotal = parseFloat($(this).find('.subtotal').attr('data-raw')) || 0;
      total += rawSubtotal;
    });

    $('#totalHarga')
      .val(formatNumber(total))        // tampilan user (terformat)
      .attr('data-raw', total);        // nilai mentah untuk submit atau validasi
  }

  $(document).ready(function () {
    // Tambah baris produk
    $('#addProdukRow').click(function () {
      let produkOptions = '';
      produkList.forEach(p => {
        produkOptions += `<option value="${p.id_produk}" data-harga="${p.modal_produk}">${p.nama_produk}</option>`;
      });

      $('#detailPembelianTable tbody').append(`
        <tr>
          <td>
            <select class="form-select produkSelect" required>
              <option value="">Pilih Produk</option>
              ${produkOptions}
            </select>
          </td>
          <td><input type="number" class="form-control kuantitas" min="1" value="1" required></td>
          <td>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon1">Rp.</span>
              <input type="text" class="form-control harga" readonly data-raw="0">
            </div>
          </td>
          <td>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon1">Rp.</span>
              <input type="text" class="form-control subtotal" readonly data-raw="0">
            </div>
          </td>
          <td><button type="button" class="btn btn-danger btn-sm removeRowBtn">Hapus</button></td>
        </tr>
      `);
    });

    // Auto-update harga dan subtotal saat produk diganti
    $('#detailPembelianTable').on('change', '.produkSelect', function () {
      const row = $(this).closest('tr');
      const selectedOption = $(this).find(':selected');
      const harga = parseFloat(selectedOption.data('harga')) || 0;
      const qty = parseFloat(row.find('.kuantitas').val()) || 1;

      const subtotal = qty * harga;

      row.find('.harga')
        .val(formatNumber(harga))
        .attr('data-raw', harga);

      row.find('.subtotal')
        .val(formatNumber(subtotal))
        .attr('data-raw', subtotal);

      hitungTotal();
    });

    // Update subtotal saat kuantitas berubah
    $('#detailPembelianTable').on('input', '.kuantitas', function () {
      const row = $(this).closest('tr');
      const qty = parseFloat(row.find('.kuantitas').val()) || 0;
      const harga = parseFloat(row.find('.harga').data('raw')) || 0;
      const subtotal = qty * harga;
      row.find('.subtotal')
        .val(formatNumber(subtotal))
        .attr('data-raw', subtotal);

      hitungTotal();
    });

    // Hapus baris produk
    $('#detailPembelianTable').on('click', '.removeRowBtn', function () {
      $(this).closest('tr').remove();
      hitungTotal();
    });

    // Submit ke API
    $('#submitPembelian').click(function () {
      const p_idSuppliers = $('#supplier').val();
      const p_namaSupplier = $('#supplier option:selected').text();
      const p_tanggal = $('#tanggal').val() + ' ' + new Date().toLocaleTimeString('en-GB', {
        hour: '2-digit', minute: '2-digit', second: '2-digit'
      });

      const payload = {
        p_idSuppliers,
        p_tanggal,
        p_totalHarga: unformatNumber($('#totalHarga').val()),
        p_detailPembelian: []
      };

      let namaProdukList = [];
      let totalPengeluaran = 0;

      $('#detailPembelianTable tbody tr').each(function () {
        const idProduk = $(this).find('.produkSelect').val();
        const namaProduk = $(this).find('.produkSelect option:selected').text();
        if (idProduk) {
          const p_kuantitas = parseInt($(this).find('.kuantitas').val()) || 0;
          const p_harga = parseFloat($(this).find('.harga').data('raw')) || 0;
          const p_subTotal = parseFloat($(this).find('.subtotal').data('raw')) || 0;

          payload.p_detailPembelian.push({ p_idProduk: idProduk, p_kuantitas, p_harga, p_subTotal });
          namaProdukList.push(namaProduk);
          totalPengeluaran += p_subTotal;
        }
      });

      if (!p_idSuppliers || !p_tanggal || payload.p_detailPembelian.length === 0) {
        Swal.fire('Gagal', 'Data belum lengkap.', 'warning');
        return;
      }

      Swal.fire({
        title: 'Yakin ingin menambahkan pembelian?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan'
      }).then(result => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'http://localhost:1111/api/laporanPembelian',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(payload),
            success: function (res) {
              // 🟡 Step 1: Update stok produk satu per satu
              const updateStokPromises = payload.p_detailPembelian.map(item => {
                return $.ajax({
                  url: `http://localhost:1111/api/produk/stok/${item.p_idProduk}`,
                  method: 'PUT',
                  contentType: 'application/json',
                  data: JSON.stringify({ p_addstokProduk: item.p_kuantitas })
                });
              });

              // 🟢 Step 2: Setelah semua update stok selesai, kirim laporan pengeluaran
              Promise.all(updateStokPromises).then(() => {
                const pengeluaranPayload = {
                  p_idKategoriPengeluaran: 1,
                  p_totalPengeluaran: totalPengeluaran,
                  p_deskripsiPengeluaran: `Pembelian Produk ${namaProdukList.join(', ')} ke ${p_namaSupplier} pada ${p_tanggal}`,
                  p_tanggal: p_tanggal
                };
                console.log(pengeluaranPayload);

                $.ajax({
                  url: 'http://localhost:1111/api/laporanPengeluaran',
                  method: 'POST',
                  contentType: 'application/json',
                  data: JSON.stringify(pengeluaranPayload),
                  success: function () {
                      // Ambil kode pembelian dari response sebelumnya
                      const kodePembelian = res.data.p_kodePembelian;
                      const p_namaKaryawan = <?= json_encode(session('tb_petugas')['nama_user']) ?>;

                      // Step 3: Tambah laporan stok per produk
                      const laporanStokPromises = payload.p_detailPembelian.map(item => {
                        const data = {
                          p_kodeLaporan: kodePembelian,
                          p_idProduk: item.p_idProduk,
                          p_namaKaryawan: p_namaKaryawan,
                          p_perubahanStok: `+ ${item.p_kuantitas}`,
                          p_alasanPerubahan: 'Pembelian Produk Dari Supplier'
                        };
                        console.log(data);
                        return $.ajax({
                          url: 'http://localhost:1111/api/laporanStok',
                          method: 'POST',
                          contentType: 'application/json',
                          data: JSON.stringify(data)
                        });
                      });

                      Promise.all(laporanStokPromises)
                        .then(() => {
                          Swal.fire('Berhasil', res.message, 'success').then(() => location.reload());
                        })
                        .catch(() => {
                          Swal.fire('Error', 'Pembelian & pengeluaran tersimpan, tapi gagal menyimpan laporan stok.', 'warning').then(() => location.reload());
                        });
                    },
                  error: function () {
                    Swal.fire('Error', 'Pembelian tersimpan, tapi gagal menyimpan laporan pengeluaran.', 'warning').then(() => location.reload());
                  }
                });
              }).catch(() => {
                Swal.fire('Error', 'Gagal memperbarui stok produk.', 'error');
              });
            },
            error: function (xhr) {
              const msg = xhr.responseJSON?.message || 'Gagal menyimpan pembelian';
              Swal.fire('Error', msg, 'error');
            }
          });
        }
      });
    });
  });
</script>

