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
            <h3>Data Petugas</h3>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addpetugasModal">Add Data Petugas</button>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tablePetugas">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>ID Petugas</th>
                                <th>Nama Petugas</th>
                                <th>Hak Akses</th>
                                <th>Status Petugas</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($petugas as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item['data_user']['kode_user'] }}</td>
                                <td>{{ $item['data_user']['nama_user'] }}</td>
                                <td>{{ $item['data_user']['role_user'] }}</td>
                                <td>{{ $item['data_user']['status_user'] }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editpetugasModal"
                                            data-idpetugas="{{ $item['id_karyawan'] }}"
                                            data-iduser="{{ $item['data_user']['id_user'] }}"
                                            data-kodepetugas="{{ $item['data_user']['kode_user'] }}"
                                            data-namapetugas="{{ $item['data_user']['nama_user'] }}"
                                            data-telppetugas="{{ $item['data_user']['contact_user'] }}"
                                            data-rolepetugas="{{ $item['data_user']['role_user'] }}"
                                            data-statuspetugas="{{ $item['data_user']['status_user'] }}"
                                            data-fotopetugas="{{ $item['data_user']['gambar_user'] }}"
                                            data-posisipetugas="{{ $item['posisi_karyawan'] }}"
                                            data-gajipetugas="{{ $item['gaji_karyawan'] }}"
                                            data-alamatpetugas="{{ $item['alamat_karyawan'] }}"
                                            data-idshifts="{{ $item['data_shift']['id_shift'] }}"
                                            data-namashifts="{{ $item['data_shift']['nama_shift'] }}"
                                            data-starttime="{{ $item['data_shift']['start_time'] }}"
                                            data-endtime="{{ $item['data_shift']['end_time'] }}">
                                            Edit
                                        </button>
                                        <button class="btn btn-danger w-100 deleteSwal"
                                            data-idpetugas="{{ $item['id_karyawan'] }}"
                                            data-namapetugas="{{ $item['data_user']['nama_user'] }}"
                                            data-action="{{ route('admin.datapetugas.delete', $item['id_karyawan']) }}">
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
    @extends('admin.modal.petugas.addpetugas')
    @extends('admin.modal.petugas.editpetugas')
    @extends('admin.modal.petugas.deletepetugas')
@endsection
@section('scripts')
    <script>
        const shiftData = @json($shifts);

        $('#shift_addpetugas').on('change', function () {
            const selectedId = $(this).val();
            const selectedShift = shiftData.find(shift => shift.id_shifts == selectedId);

            if (selectedShift) {
                const start = selectedShift.start_time.slice(0, 5);
                const end = selectedShift.end_time.slice(0, 5);
                $('#waktushift_addpetugas').val(`${start} - ${end}`);
            } else {
                $('#waktushift_addpetugas').val('');
            }
        });

        $('#shift_editpetugas').on('change', function () {
            const selectedId = $(this).val();
            const selectedShift = shiftData.find(shift => shift.id_shifts == selectedId);

            if (selectedShift) {
                const start = selectedShift.start_time.slice(0, 5);
                const end = selectedShift.end_time.slice(0, 5);
                $('#waktushift_editpetugas').val(`${start} - ${end}`);
            } else {
                $('#waktushift_editpetugas').val('');
            }
        });

        $(document).ready(function() {
            const d = new Date();
            const tanggal = `Data Petugas-${('0' + d.getDate()).slice(-2)}${('0' + (d.getMonth() + 1)).slice(-2)}${d.getFullYear()}`;
            $('#tablePetugas').DataTable({
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
