@extends('app')
<link rel="icon" href="{{ URL::asset('images/logo/favicon.png') }}" type="image/png" />
@section('styles')
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Data Produk</h3>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addprodukModal">Add Data Produk</button>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tableProduk">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>ID Produk</th>
                                <th>Kategori</th>
                                <th>Nama Produk</th>
                                <th>Stok Produk</th>
                                <th>Harga Jual</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produk as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item['sku_produk'] }}</td>
                                <td>{{ $item['kategori'][0]['nama_kategori'] }}</td>
                                <td>{{ $item['nama_produk'] }}</td>
                                <td>{{ $item['stok_produk'] }}</td>
                                <td>Rp. {{ number_format($item['harga_produk'], 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editprodukModal"
                                        data-idproduk="{{ $item['id_produk'] }}" data-kodeproduk="{{ $item['sku_produk'] }}"
                                        data-idkategori="{{ $item['kategori'][0]['id_kategori'] }}" data-idsubkategori="{{ $item['kategori'][0]['id_subkategori'] }}"
                                        data-namakategori="{{ $item['kategori'][0]['nama_kategori'] }}" data-namasubkategori="{{ $item['kategori'][0]['nama_subkategori'] }}"
                                        data-namaproduk="{{ $item['nama_produk'] }}" data-barcodeproduk="{{ $item['barcode_produk'] }}"
                                        data-deskripsiproduk="{{ $item['deskripsi_produk'] }}" data-hargaproduk="{{ $item['harga_produk'] }}"
                                        data-modalproduk="{{ $item['modal_produk'] }}" data-diskonproduk="{{ $item['diskon_prpduk'] }}"
                                        data-stokproduk="{{ $item['stok_produk'] }}" data-stokminimumproduk="{{ $item['stok_minimum_produk'] }}"
                                        data-statusproduk="{{ $item['status_produk'] }}" data-fotoproduk="{{ $item['gambar_produk'] }}">
                                            Edit
                                        </button>
                                        <button class="btn btn-danger w-100 deleteSwal"
                                        data-idproduk="{{ $item['id_produk'] }}" data-namaproduk="{{ $item['nama_produk'] }}"
                                        data-action="{{ route('admin.dataproduk.delete', $item['id_produk']) }}">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @extends('admin.modal.produk.addproduk')
    @extends('admin.modal.produk.editproduk')
    @extends('admin.modal.produk.deleteproduk')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            const d = new Date();
            const tanggal = `Data Produk-${('0' + d.getDate()).slice(-2)}${('0' + (d.getMonth() + 1)).slice(-2)}${d.getFullYear()}`;
            $('#tableProduk').DataTable({
                layout: {
                    topStart: {
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            title: tanggal
                        },
                        {
                            extend: 'excelHtml5',
                            title: tanggal
                        },
                        {
                            extend: 'pdfHtml5',
                            title: tanggal
                        },
                        {
                            extend: 'csvHtml5',
                            title: tanggal
                        }
                    ]
                }
            },
            });
        });
    </script>
@endsection
