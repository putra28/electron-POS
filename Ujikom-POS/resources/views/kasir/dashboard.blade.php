@extends('app')
<link rel="icon" href="{{ asset('images/logo/favicon.png') }}" type="image/png" />
@section('styles')
    <style>
        .icon-container {
            width: 50px;
            /* Lebar dan tinggi div */
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            /* Membuat bentuk lingkaran */
        }

        body {
            font-family: 'Outfit', sans-serif;
        }

        .icon {
            color: #cecece;
            /* Warna ikon */
        }

        .card-text {
            font-size: 20px !important;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <h3>Dashboard</h3>
        <div class="row mb-3">
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Tanggal</h5>
                                <span class="h2 font-weight-bold mb-0">Bulan Ini</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon-container bg-dark">
                                    <i class="icon fa fa-calendar"></i>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-nowrap">{{ now()->format('d/m/Y') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Penjualan</h5>
                                <span class="h2 font-weight-bold mb-0">Bulan ini</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon-container bg-dark">
                                    <i class="icon fa fa-arrow-up"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ $periodepenjualan }}</span>
                            <span class="text-nowrap">Penjualan</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Pendapatan</h5>
                                <span class="h2 font-weight-bold mb-0">Bulan Ini</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon-container bg-dark">
                                    <i class="icon fa fa-dollar"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> Rp.</span>
                            <span class="text-success mr-2"></i>{{ number_format($totalpenjualan, 0, ',', '.') }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total</h5>
                                <span class="h2 font-weight-bold mb-0">Produk</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon-container bg-dark">
                                    <i class="icon fa fa-shirt"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{$totalproduk}}</span>
                            <span class="text-nowrap">Produk</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <div class="card" style="height: 100%">
                    <div class="card-body">
                        <h3 class="card-title">Data Diri</h3>
                        <div class="row align-items-center">
                            <div class="col">
                                <p class="card-text">
                                    <strong>Nama :</strong>
                                </p>
                                <p class="card-text">
                                    {{ Session::has('tb_petugas') ? Session::get('tb_petugas')['nama_user'] : 'Nama Petugas' }}<br>
                                </p>
                                <p class="card-text">
                                    <strong>Alamat Rumah :</strong>
                                </p>
                                <p class="card-text">
                                    {{ Session::has('tb_petugas') ? Session::get('tb_petugas')['data_user']['alamat_karyawan'] : 'Alamat Petugas' }}<br>
                                </p>
                            </div>
                            <div class="col-auto">
                                <img src="{{ session('foto_petugas') ? session('foto_petugas') : 'https://placehold.co/200' }}"
                                alt="Foto Petugas" class="profile-photo" height="200px" width="200px">
                            </div>
                        </div>

                        <hr>

                        <div class="row align-items-center">
                            <div class="col">
                                <p class="card-text">
                                    <strong>Kode Petugas :</strong>
                                </p>
                                <p class="card-text">
                                    {{ Session::has('tb_petugas') ? Session::get('tb_petugas')['kode_user'] : 'Kode Petugas' }}<br>
                                </p>
                                <p class="card-text">
                                    <strong>Nomor Telepon :</strong>
                                </p>
                                <p class="card-text">
                                    {{ Session::has('tb_petugas') ? Session::get('tb_petugas')['contact_user'] : 'No. Telp Petugas' }}<br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-3">
                <div class="card" style="height: 100%">
                    <div class="card-body">
                        <h5 class="card-title">Transaksi Terakhir</h5>
                        <table class="table table-striped table-bordered table-hover" id="tableTransaksi">
                            <thead>
                                <tr>
                                    <th style="width: 30%;"><strong>Kode Transaksi</strong></th>
                                    <th>Total Harga</th>
                                    <th>Tanggal Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penjualan as $key => $item)
                                <tr>
                                    <td>{{ $item['kode_penjualan'] }}</td>
                                    <td>Rp. {{ number_format($item['total_harga'], 0, ',', '.') }}</td>
                                    <td>{{ $item['tanggal_penjualan'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @extends('kasir.modal.member.addmember')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tableTransaksi').DataTable({
                lengthChange: false,
                pageLength: 8
            });
        });
    </script>
@endsection
