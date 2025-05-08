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
                <h3>Data Riwayat Pengeluaran</h3>
            </div>
            <div class="col-md-8 text-end">
                <form action="#" method="GET" class="d-inline-block">
                    <div class="input-group">
                        <span class="input-group-text bg-dark text-white">Periode</span>
                        <input type="date" class="form-control" name="startdate" value="{{ session('startDate', \Carbon\Carbon::now()->startOfYear()->format('Y-m-d')) }}">
                        <span class="input-group-text">-</span>
                        <input type="date" class="form-control" name="enddate" value="{{ session('endDate', \Carbon\Carbon::now()->endOfYear()->format('Y-m-d')) }}">
                        <button type="submit" class="btn btn-outline-primary">Terapkan</button>
                        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addpengeluaranModal">Add Data Pengeluaran</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tablePengeluaran">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>No. Pengeluaran</th>
                                <th>Tanggal</th>
                                <th>Jenis Pengeluaran</th>
                                <th>Total Pengeluaran</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengeluaran as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item['kode_pengeluaran'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d-m-Y') }}</td>
                                    <td>{{ $item['nama_kategori_pengeluaran'] ?? 'Kategori' }}</td>
                                    <td>Rp. {{ number_format($item['total_pengeluaran'], 0, ',', '.') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn {{ $item['id_kategori_pengeluaran'] == 1 ? 'btn-secondary' : 'btn-primary' }} w-100"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editpengeluaranModal"
                                                data-idpengeluaran="{{ $item['id_pengeluaran'] }}"
                                                data-nopengeluaran="{{ $item['kode_pengeluaran'] }}"
                                                data-totalHargapengeluaran="{{ number_format($item['total_pengeluaran'], 0, ',', '.') }}"
                                                data-deskripsipengeluaran="{{ $item['deskripsi_pengeluaran'] }}"
                                                data-tglpengeluaran="{{ $item['tanggal'] }}"
                                                data-updatedat="{{ $item['updated_at'] }}"
                                                data-namakategoripengeluaran="{{ $item['nama_kategori_pengeluaran'] ?? '-' }}"
                                                data-idkategoripengeluaran="{{ $item['id_kategori_pengeluaran'] ?? '-' }}">
                                                {{ $item['id_kategori_pengeluaran'] == 1 ? 'View' : 'Edit' }}
                                            </button>

                                            @if ($item['id_kategori_pengeluaran'] != 1)
                                                <button class="btn btn-danger w-100 deleteSwal"
                                                    data-idpengeluaran="{{ $item['id_pengeluaran'] }}"
                                                    data-nopengeluaran="{{ $item['kode_pengeluaran'] }}"
                                                    data-action="{{ route('admin.datapengeluaran.delete', $item['id_pengeluaran']) }}">
                                                    Delete
                                                </button>
                                            @endif
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
    @extends('admin.modal.pengeluaran.addpengeluaran')
    @extends('admin.modal.pengeluaran.editpengeluaran')
    @extends('admin.modal.pengeluaran.deletepengeluaran')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            const d = new Date();
            const tanggal = `Data Riwayat Pengeluaran-${('0' + d.getDate()).slice(-2)}${('0' + (d.getMonth() + 1)).slice(-2)}${d.getFullYear()}`;
            $('#tablePengeluaran').DataTable({
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
