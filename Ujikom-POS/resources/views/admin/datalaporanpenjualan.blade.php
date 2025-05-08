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

        .icon {
            color: #cecece;
            /* Warna ikon */
        }

        .card-text {
            font-size: 20px !important;
        }

        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h3>Laporan Penjualan Tahun 2025</h3>
            </div>
            <div class="col-md-6 text-end">
                <form action="#" method="GET" class="d-inline-block" id="tahunForm">
                    <div class="input-group">
                        <button type="button" class="btn btn-outline-secondary" id="decreaseYear">-</button>
                        <input type="number" class="form-control text-center" id="tahunInput" name="tahun" value="{{ $tahun }}" readonly>
                        <button type="button" class="btn btn-outline-secondary" id="increaseYear">+</button>
                        <button type="submit" class="btn btn-outline-primary">Terapkan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats h-100 mb-4 mb-xl-0">
                    <div class="card-body d-flex flex-column">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total</h5>
                                <span class="h4 font-weight-bold mb-0">Transaksi</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon-container bg-dark">
                                    <i class="icon fa fa-receipt"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-auto mb-0 text-muted text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ count($penjualan) }}</span>
                            <span class="text-nowrap">Penjualan</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats h-100 mb-4 mb-xl-0">
                    <div class="card-body d-flex flex-column">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total</h5>
                                <span class="h4 font-weight-bold mb-0">Barang Terjual</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon-container bg-dark">
                                    <i class="icon fa fa-boxes-stacked"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-auto mb-0 text-muted text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ $total_kuantitas }}</span>
                            <span class="text-nowrap">Terjual</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats h-100 mb-4 mb-xl-0">
                    <div class="card-body d-flex flex-column">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total</h5>
                                <span class="h4 font-weight-bold mb-0">Pemasukan</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon-container bg-dark">
                                    <i class="icon fa fa-money-bill-wave"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-auto mb-0 text-muted text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> Rp {{ number_format($total_pemasukan, 0, ',', '.') }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats h-100 mb-4 mb-xl-0">
                    <div class="card-body d-flex flex-column">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total</h5>
                                <span class="h4 font-weight-bold mb-0">Keuntungan</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon-container bg-dark">
                                    <i class="icon fa fa-chart-line"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-auto mb-0 text-muted text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> Rp {{ number_format($total_keuntungan, 0, ',', '.') }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card" style="height: 100%">
                    <div class="card-body">
                        <h5>Produk Terlaris: {{ $nama_produk_terlaris }}</h5>
                        <table class="table table-bordered" id="tableProduk">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Jumlah Terjual</th>
                                    <th>Total Omset</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produk_terlaris as $nama => $data)
                                <tr>
                                    <td>{{ $nama }}</td>
                                    <td>{{ $data['jumlah'] }}</td>
                                    <td>Rp {{ number_format($data['total'], 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style="height: 100%">
                    <div class="card-body">
                        <h5>Karyawan dengan Penjualan Terbanyak: {{ $karyawan_terbaik }}</h5>
                        <canvas id="penjualanChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tahunInput = document.getElementById('tahunInput');
        document.getElementById('decreaseYear').addEventListener('click', function () {
            tahunInput.value = parseInt(tahunInput.value) - 1;
        });

        document.getElementById('increaseYear').addEventListener('click', function () {
            tahunInput.value = parseInt(tahunInput.value) + 1;
        });
    });

    $(document).ready(function() {
        $('#tableProduk').DataTable({
            lengthChange: false,
            searching: false,
            ordering: false
        });
    });

    const ctx = document.getElementById('penjualanChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chart_labels) !!}, // ex: ['Jan', 'Feb', 'Mar']
            datasets: [{
                label: 'Penjualan Bulanan',
                data: {!! json_encode($chart_values) !!}, // ex: [1000000, 2000000, 1500000]
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                fill: 'start', // ini aktifkan area bawah
                tension: 0.4,  // ini bikin smooth
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Grafik Penjualan Bulanan'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            },
            elements: {
                line: {
                    tension: 0.8 // smooth garis
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
