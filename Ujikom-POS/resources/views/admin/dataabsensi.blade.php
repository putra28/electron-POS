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
            <h3>Data Kehadiran</h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tableAbsensi">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Nama Karyawan</th>
                                <th>Jadwal Shift</th>
                                <th>Waktu Clock In</th>
                                <th>Waktu Clock Out</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absensi as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($item['tanggal_kehadiran'])->format('d-m-Y') }}</td>
                                <td>{{ $item['data_karyawan']['nama_Karyawan'] }}</td>
                                <td>{{ $item['data_shift']['nama_shift'] }}</td>
                                <td>{{ $item['waktu_clockIn'] }}</td>
                                <td>{{ $item['waktu_clockOut'] }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#viewabsensiModal"
                                        data-idabsensi="{{ $item['id_kehadiran'] }}" data-tanggal="{{ \Carbon\Carbon::parse($item['tanggal_kehadiran'])->format('d-m-Y') }}"
                                        data-waktuclockin="{{ $item['waktu_clockIn'] }}" data-waktuclockout="{{ $item['waktu_clockOut'] }}"
                                        data-totalJamKerja="{{ $item['total_jam_kerja'] }}" data-totalOvertime="{{ $item['total_overtime'] }}"
                                        data-namaKaryawan="{{ $item['data_karyawan']['nama_Karyawan'] }}" data-posisiKaryawan="{{ $item['data_karyawan']['posisi_karyawan'] }}"
                                        data-namaShift="{{ $item['data_shift']['nama_shift'] }}" data-startTime="{{ $item['data_shift']['startTime'] }}" data-endTime="{{ $item['data_shift']['endTime'] }}">
                                            View
                                        </button>
                                        <button class="btn btn-danger w-100 deleteSwal"
                                        data-idabsensi="{{ $item['id_kehadiran'] }}"
                                        data-action="{{ route('admin.dataabsensi.delete', $item['id_kehadiran']) }}">Delete</button>
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
    @extends('admin.modal.absensi.viewabsensi')
    @extends('admin.modal.absensi.deleteabsensi')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            const d = new Date();
            const tanggal = `Data Laporan Kehadiran-${('0' + d.getDate()).slice(-2)}${('0' + (d.getMonth() + 1)).slice(-2)}${d.getFullYear()}`;
            $('#tableAbsensi').DataTable({
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
