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
            <div class="col-md-4">
                <h3>Data Riwayat Pembelian</h3>
            </div>
            <div class="col-md-8 text-end">
                <form action="#" method="GET" class="d-inline-block">
                    <div class="input-group">
                        <span class="input-group-text bg-dark text-white">Periode</span>
                        <input type="date" class="form-control" name="startdate" value="{{ session('startDate', \Carbon\Carbon::now()->startOfYear()->format('Y-m-d')) }}">
                        <span class="input-group-text">-</span>
                        <input type="date" class="form-control" name="enddate" value="{{ session('endDate', \Carbon\Carbon::now()->endOfYear()->format('Y-m-d')) }}">
                        <button type="submit" class="btn btn-outline-primary">Terapkan</button>
                        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addpembelianModal">Add Data Pembelian</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tablePembelian">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>No. Pembelian</th>
                                <th>Tanggal</th>
                                <th>Supplier</th>
                                <th>Total Pembelian</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembelian as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item['kode_pembelian'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item['tanggal_pembelian'])->format('d-m-Y') }}</td>
                                    <td>{{ $item['supplier']['nama_suppliers'] ?? 'Non-Member' }}</td>
                                    <td>Rp. {{ number_format($item['total_harga'], 0, ',', '.') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-primary w-100"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editpembelianModal"
                                                    data-idpembelian="{{ $item['id_pembelian'] }}"
                                                    data-nopembelian="{{ $item['kode_pembelian'] }}"
                                                    data-totalHargapembelian="{{ number_format($item['total_harga'], 0, ',', '.') }}"
                                                    data-tglpembelian="{{ $item['tanggal_pembelian'] }}"
                                                    data-updatedat="{{ $item['updated_at'] }}"
                                                    data-supplier="{{ $item['supplier']['nama_suppliers'] ?? '-' }}"
                                                    data-detail='@json($item['detail_pembelian'])'>
                                                Edit
                                            </button>
                                            <button class="btn btn-danger w-100 deleteSwal"
                                                data-idpembelian="{{ $item['id_pembelian'] }}"
                                                data-nopembelian="{{ $item['kode_pembelian'] }}"
                                                data-action="{{ route('admin.datapembelian.delete', $item['id_pembelian']) }}">
                                                Delete
                                            </button>
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
    @extends('admin.modal.pembelian.addpembelian')
    @extends('admin.modal.pembelian.editpembelian')
    @extends('admin.modal.pembelian.deletepembelian')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            const d = new Date();
            const tanggal = `Data Riwayat Pembelian-${('0' + d.getDate()).slice(-2)}${('0' + (d.getMonth() + 1)).slice(-2)}${d.getFullYear()}`;
            $('#tablePembelian').DataTable({
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
