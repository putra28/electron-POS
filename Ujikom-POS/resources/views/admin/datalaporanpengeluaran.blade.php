@extends('app')
<link rel="icon" href="{{ asset('images/logo/favicon.png') }}" type="image/png" />
@section('styles')
    <style>
        .icon-container {
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
        }

        .icon {
            color: #cecece;
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
            <h3>Laporan Pengeluaran Tahun 2025</h3>
        </div>
        <div class="col-md-6 text-end">
            <form action="#" method="GET" class="d-inline-block" id="tahunForm">
                <div class="input-group">
                    <button type="button" class="btn btn-outline-secondary" id="decreaseYear">-</button>
                    <input type="number" class="form-control text-center" id="tahunInput" name="tahun" value="2025" readonly>
                    <button type="button" class="btn btn-outline-secondary" id="increaseYear">+</button>
                    <button type="submit" class="btn btn-outline-primary">Terapkan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-xl-4 col-lg-6">
            <div class="card card-stats h-100 mb-4 mb-xl-0">
                <div class="card-body d-flex flex-column">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total</h5>
                            <span class="h4 font-weight-bold mb-0">Pendapatan</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon-container bg-dark">
                                <i class="icon fa fa-dollar"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-auto mb-0 text-muted text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> Rp {{ number_format($total_pendapatan) }}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card card-stats h-100 mb-4 mb-xl-0">
                <div class="card-body d-flex flex-column">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total</h5>
                            <span class="h4 font-weight-bold mb-0">HPP</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon-container bg-dark">
                                <i class="icon fa fa-boxes-stacked"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-auto mb-0 text-muted text-sm">
                        <span class="text-info mr-2"><i class="fa fa-arrow-right"></i> Rp {{ number_format($total_hpp) }}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card card-stats h-100 mb-4 mb-xl-0">
                <div class="card-body d-flex flex-column">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total</h5>
                            <span class="h4 font-weight-bold mb-0">Keuntungan Kotor</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon-container bg-dark">
                                <i class="icon fa fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-auto mb-0 text-muted text-sm">
                        <span class="text-primary mr-2"><i class="fa fa-arrow-up"></i> Rp {{ number_format($laba_kotor) }}</span>
                    </p>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats h-100 mb-4 mb-xl-0">
                <div class="card-body d-flex flex-column">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total</h5>
                            <span class="h5 font-weight-bold mb-0">Pengeluaran Lain</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon-container bg-dark">
                                <i class="icon fa fa-cash-register"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-auto mb-0 text-muted text-sm">
                        <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> Rp {{ number_format($pengeluaran_lain) }}</span>
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
                            <span class="h4 font-weight-bold mb-0">Laba Bersih</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon-container bg-dark">
                                <i class="icon fa fa-smile"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-auto mb-0 text-muted text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> Rp {{ number_format($laba_bersih) }}</span>
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
                            <span class="h4 font-weight-bold mb-0">Pembelian Barang</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon-container bg-dark">
                                <i class="icon fa fa-truck"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-auto mb-0 text-muted text-sm">
                        <span class="text-info mr-2"><i class="fa fa-arrow-right"></i> {{ $total_transaksi_pembelian }} Transaksi</span>
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
                            <span class="h4 font-weight-bold mb-0">Transaksi Penjualan</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon-container bg-dark">
                                <i class="icon fa fa-receipt"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-auto mb-0 text-muted text-sm">
                        <span class="text-info mr-2"><i class="fa fa-arrow-right"></i> {{ $total_transaksi_penjualan }} Transaksi</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card" style="height: 100%">
                <div class="card-body">
                    <h5>Tabel Pengeluaran</h5>
                    <table class="table table-bordered" id="tablePengeluaran">
                        <thead class="thead-dark">
                            <tr>
                                <th>Jenis Pengeluaran</th>
                                <th>Total Pengeluaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenis_pengeluaran_list as $i => $nama)
                            <tr>
                                <td>{{ $nama }}</td>
                                <td>Rp {{ number_format($pengeluaran_per_jenis[$i], 0, ',', '.') }}</td>
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
                    <h5>Perbandingan Pendapatan & Pengeluaran</h5>
                    <canvas id="pengeluaranChart" height="250"></canvas>
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

    $(document).ready(function () {
        $('#tablePengeluaran').DataTable({
            lengthChange: false,
            searching: false,
            ordering: false
        });
    });

    const ctx = document.getElementById('pengeluaranChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chart_labels) !!},
            datasets: [
                {
                    label: 'Penjualan Bulanan',
                    data: {!! json_encode($chart_penjualan) !!},
                    backgroundColor: 'rgba(0, 128, 0, 0.2)', // hijau muda
                    borderColor: 'rgba(0, 128, 0, 1)', // hijau
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(0, 128, 0, 1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Pengeluaran Bulanan',
                    data: {!! json_encode($chart_pengeluaran) !!},
                    backgroundColor: 'rgba(255, 0, 0, 0.2)', // merah muda
                    borderColor: 'rgba(255, 0, 0, 1)', // merah
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(255, 0, 0, 1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Perbandingan Penjualan dan Pengeluaran Bulanan'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return context.dataset.label + ': Rp ' + value.toLocaleString();
                        }
                    }
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
