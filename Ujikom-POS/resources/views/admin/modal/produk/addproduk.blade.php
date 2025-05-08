<!-- Modal -->
<div class="modal fade" id="addprodukModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::asset('/admin/dataproduk/add') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nama_addproduk" placeholder="Nama Produk" name="nama_addproduk" required>
                                <label for="nama_addproduk">Nama Produk</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="kategori_addproduk" name="kategori_addproduk" required>
                                    <option selected disabled>Pilih Jenis Kategori</option>
                                    @foreach ($kategori as $kat)
                                        <option value="{{ $kat['id_kategori'] }}">{{ $kat['nama_kategori'] }}</option>
                                    @endforeach
                                </select>
                                <label for="kategori_addproduk">Kategori</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="subkategori_addproduk" name="subkategori_addproduk" required>
                                    <option selected disabled>Pilih Jenis Sub-Kategori</option>
                                    @foreach ($kategori as $kat)
                                        @foreach ($kat['data_subkategori'] as $sub)
                                            <option value="{{ $sub['id_subkategori'] }}"
                                                    data-kategori-id="{{ $kat['id_kategori'] }}">
                                                {{ $sub['nama_subkategori'] }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                                <label for="subkategori_addproduk">Sub-Kategori</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <div class="form-floating is-invalid">
                                    <input type="text" class="form-control" id="hargaModal_addproduk"
                                        name="hargaModal_addproduk" placeholder="100" required>
                                    <label for="hargaModal_addproduk">Harga Modal Produk</label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <div class="form-floating is-invalid">
                                    <input type="text" class="form-control" id="hargaJual_addproduk"
                                        name="hargaJual_addproduk" placeholder="100" required>
                                    <label for="hargaJual_addproduk">Harga Jual Produk</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                                <div class="form-floating is-invalid">
                                    <input type="number" class="form-control" id="diskon_addproduk"
                                        name="diskon_addproduk" value="0" placeholder="100" required>
                                    <label for="diskon_addproduk">Diskon Produk</label>
                                </div>
                                <span class="input-group-text" id="basic-addon1">%</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <div class="form-floating is-invalid">
                                    <input type="text" class="form-control" id="hargaDiskon_addproduk"
                                        name="hargaDiskon_addproduk" placeholder="100" required readonly>
                                    <label for="hargaDiskon_addproduk">Harga Setelah Diskon</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="stok_addproduk" placeholder="Stok Produk" name="stok_addproduk" required>
                                <label for="stok_addproduk">Stok Produk</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="stokMin_addproduk" placeholder="Stok Produk" name="stokMin_addproduk" required>
                                <label for="stokMin_addproduk">Stok Minimum</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <select class="form-select" aria-label="Default select example" id="status_addproduk"
                                    name="status_addproduk" required>
                                    <option selected>Pilih Status Produk</option>
                                    <option value="Available">Tersedia</option>
                                    <option value="Kosong">Tidak Tersedia</option>
                                </select>
                                <label for="status_addproduk">Status Produk</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="deskripsi_addproduk" placeholder="Deskripsi Produk" name="deskripsi_addproduk" required></textarea>
                                <label for="deskripsi_addproduk">Deskripsi Produk</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="foto_addproduk">Foto Produk</label>
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control" id="foto_addproduk" placeholder="Foto Produk" name="foto_addproduk">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addbutton_swal" data-namaprodukswal="">Save changes</button>
                </div>
            </form>
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

    function hitungHargaDiskonAddProduk() {
        const hargaJualInput = document.getElementById('hargaJual_addproduk');
        const hargaModalInput = document.getElementById('hargaModal_addproduk');
        const diskonInput = document.getElementById('diskon_addproduk');
        const hargaDiskonInput = document.getElementById('hargaDiskon_addproduk');

        const hargaJual = parseInt(unformatNumber(hargaJualInput.value)) || 0;
        const hargaModal = parseInt(unformatNumber(hargaModalInput.value)) || 0;
        const diskon = parseFloat(unformatNumber(diskonInput.value)) || 0;

        const hasilDiskon = hargaJual - (hargaJual * (diskon / 100));
        hargaDiskonInput.value = formatNumber(Math.floor(hasilDiskon));
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Format dan hitung harga diskon otomatis saat user input
        const hargaModal = document.getElementById('hargaModal_addproduk');
        const hargaJual = document.getElementById('hargaJual_addproduk');
        const diskon = document.getElementById('diskon_addproduk');

        hargaModal.addEventListener('input', function () {
            const unformatted = unformatNumber(this.value);
            this.value = formatNumber(unformatted);
        });

        hargaJual.addEventListener('input', function () {
            const unformatted = unformatNumber(this.value);
            this.value = formatNumber(unformatted);
            hitungHargaDiskonAddProduk();
        });

        diskon.addEventListener('input', function () {
            hitungHargaDiskonAddProduk();
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
                    // Unformat dulu sebelum submit
                    $('#hargaModal_addproduk').val(unformatNumber($('#hargaModal_addproduk').val()));
                    $('#hargaJual_addproduk').val(unformatNumber($('#hargaJual_addproduk').val()));
                    $('#diskon_addproduk').val(unformatNumber($('#diskon_addproduk').val()));

                    $('#addprodukModal form').submit();
                }
            });
        });

    // Formatting angka saat input
    const hargaModalInput = document.getElementById('hargaModal_addproduk');
    const hargaJualInput = document.getElementById('hargaJual_addproduk');
    const diskonInput = document.getElementById('diskon_addproduk');

    [hargaJualInput, hargaModalInput, diskonInput].forEach(input => {
        input.addEventListener('input', function (e) {
            const raw = unformatNumber(e.target.value);
            if (!isNaN(raw)) {
                e.target.value = formatNumber(raw);
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const addkategoriSelect = document.getElementById('kategori_addproduk');
        const addsubkategoriSelect = document.getElementById('subkategori_addproduk');

        // Simpan semua opsi subkategori di awal
        const allSubkategoriOptions = Array.from(addsubkategoriSelect.options).slice(1); // Skip "Pilih Jenis Sub-Kategori"

        const updateSubkategoriState = () => {
            if (addkategoriSelect.selectedIndex === 0) {
                addsubkategoriSelect.setAttribute('disabled', true);
            } else {
                addsubkategoriSelect.removeAttribute('disabled');
            }
        };

        updateSubkategoriState();

        addkategoriSelect.addEventListener('change', function () {
            const selectedKategoriId = this.value;

            // Reset subkategori
            addsubkategoriSelect.innerHTML = '<option selected disabled>Pilih Jenis Sub-Kategori</option>';

            // Filter subkategori sesuai id_kategori yang dipilih
            const filteredOptions = allSubkategoriOptions.filter(option => {
                return option.dataset.kategoriId === selectedKategoriId;
            });

            // Tambahkan opsi yang lolos filter
            filteredOptions.forEach(option => {
                addsubkategoriSelect.appendChild(option);
            });

            updateSubkategoriState();
        });
    });
</script>
