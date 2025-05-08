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
            <h3>Jadwal Shift Karyawan</h3>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addshiftModal">Add Jadwal Shift</button>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tableShift">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>Jadwal Shift</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shifts as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item['nama_shifts'] }}</td>
                                <td>{{ $item['start_time'] }}</td>
                                <td>{{ $item['end_time'] }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editShiftModal"
                                            data-idShift="{{ $item['id_shifts'] }}"
                                            data-namaShift="{{ $item['nama_shifts'] }}"
                                            data-startTime="{{ $item['start_time'] }}"
                                            data-endTime="{{ $item['end_time'] }}">
                                            Edit
                                        </button>
                                        <button class="btn btn-danger w-100 deleteSwal"
                                            data-idShift="{{ $item['id_shifts'] }}"
                                            data-namaShift="{{ $item['nama_shifts'] }}"
                                            data-action="{{ route('admin.datashift.delete', $item['id_shifts']) }}">
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
    @extends('admin.modal.shift.addshift')
    @extends('admin.modal.shift.editshift')
    @extends('admin.modal.shift.deleteshift')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            const d = new Date();
            const tanggal = `Data Jadwal Shift-${('0' + d.getDate()).slice(-2)}${('0' + (d.getMonth() + 1)).slice(-2)}${d.getFullYear()}`;
            $('#tableShift').DataTable({
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
