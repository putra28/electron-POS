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
            <h3>Permintaan Izin Kehadiran Karyawan</h3>
            <button class="btn btn-success mb-3"
                data-bs-toggle="modal"
                data-bs-target="#addIzinModal"
                data-kategori="{{ json_encode($kategoriIzin) }}">
                Add Perizinan
            </button>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tablePerizinan">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>Tgl Pengajuan</th>
                                <th>Nama Karyawan</th>
                                <th>Jenis Izin</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Berakhir</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($izinKaryawan as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($item['created_at'])->format('d-m-Y') }}</td>
                                <td>{{ $item['data_karyawan']['nama_karyawan'] }}</td>
                                <td>{{ $item['data_izin']['nama_kategori_perizinan'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($item['start_date'])->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item['end_date'])->format('d-m-Y') }}</td>
                                <td style="background-color: {{ $item['status'] == 'Approved' ? '#C6F7D0' : ($item['status'] == 'Pending' ? '#87CEEB' : '#FFC5C5') }}">{{ $item['status'] }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editIzinModal"
                                        data-idizin="{{ $item['id_izin_karyawan'] }}" data-tanggal="{{ \Carbon\Carbon::parse($item['created_at'])->format('d-m-Y') }}"
                                        data-namakaryawan="{{ $item['data_karyawan']['nama_karyawan'] }}" data-posisikaryawan="{{ $item['data_karyawan']['posisi_karyawan'] }}"
                                        data-jenisizin="{{ $item['data_izin']['nama_kategori_perizinan'] }}" data-startdate="{{ \Carbon\Carbon::parse($item['start_date'])->format('d-m-Y') }}" data-enddate="{{ \Carbon\Carbon::parse($item['end_date'])->format('d-m-Y') }}"
                                        data-status="{{ $item['status'] }}">
                                            View
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
    @extends('kasir.modal.izinKaryawan.addIzinKaryawan')
    @extends('kasir.modal.izinKaryawan.editIzinKaryawan')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            const d = new Date();
            const tanggal = `Data Laporan Perizinan Karyawan-${('0' + d.getDate()).slice(-2)}${('0' + (d.getMonth() + 1)).slice(-2)}${d.getFullYear()}`;
            $('#tablePerizinan').DataTable({
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
