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
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h3>Data Riwayat Transaksi</h3>
            </div>
            <div class="col-md-6 text-end">
                <form action="#" method="GET" class="d-inline-block">
                    <div class="input-group">
                        <span class="input-group-text bg-dark text-white">Periode</span>
                        <input type="date" class="form-control" name="startdate" value="{{ session('startDate', \Carbon\Carbon::now()->startOfYear()->format('Y-m-d')) }}">
                        <span class="input-group-text">-</span>
                        <input type="date" class="form-control" name="enddate" value="{{ session('endDate', \Carbon\Carbon::now()->endOfYear()->format('Y-m-d')) }}">
                        <button type="submit" class="btn btn-outline-primary">Terapkan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tableTransaksi">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>No. Transaksi</th>
                                <th>Kasir</th>
                                <th>Tanggal dan Waktu</th>
                                <th>Member</th>
                                <th>Total Transaksi</th>
                                <th>Status Transaksi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item['kode_penjualan'] }}</td>
                                    <td>{{ $item['karyawan']['nama_user'] ?? '-' }}</td>
                                    <td>{{ $item['tanggal_penjualan'] }}</td>
                                    <td>{{ $item['customers']['nama_customers'] ?? 'Non-Member' }}</td>
                                    <td>Rp. {{ number_format($item['total_harga'], 0, ',', '.') }}</td>
                                    <td>{{ $item['status_pembayaran'] }}</td>
                                    <td>
                                        <button class="btn btn-secondary mr-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewpenjualanModal"
                                                data-idtransaksi="{{ $item['id_penjualan'] }}"
                                                data-notransaksi="{{ $item['kode_penjualan'] }}"
                                                data-namapetugas="{{ $item['karyawan']['nama_user'] ?? '-' }}"
                                                data-tgltransaksi="{{ $item['tanggal_penjualan'] }}"
                                                data-namamember="{{ $item['customers']['nama_customers'] ?? 'Non-Member' }}"
                                                data-totaltransaksi="{{ number_format($item['total_harga'], 0, ',', '.') }}"
                                                data-totalbayar="{{ number_format($item['total_bayar'], 0, ',', '.') }}"
                                                data-kembaliantransaksi="{{ number_format($item['total_kembalian'], 0, ',', '.') }}"
                                                data-statustransaksi="{{ $item['status_pembayaran'] }}"
                                                data-detail='@json($item['detail_penjualan'])'>
                                            View
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @extends('kasir.modal.member.addmember')
    @extends('kasir.modal.penjualan.viewpenjualan')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#tableTransaksi').DataTable({
                layout: {
                topStart: {
                    buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
                }
            }
            });
        });
    </script>
@endsection
