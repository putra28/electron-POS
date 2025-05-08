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
            <h3>Data Member</h3>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tableMember">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>Status Member</th>
                                <th>Nama Lengkap</th>
                                <th>No. Telp</th>
                                <th>Alamat Email</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($member as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ ucfirst($item['status_customers']) }}</td>
                                <td>{{ $item['nama_customers'] }}</td>
                                <td>{{ $item['telp_customers'] }}</td>
                                <td>{{ $item['email_customers'] }}</td>
                                <td>{{ $item['tglLahir_customers'] !== '0000-00-00' ? $item['tglLahir_customers'] : '-' }}</td>
                                <td>{{ $item['gender_customers'] ?: '-' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editmemberModal"
                                            data-idCustomers="{{ $item['id_customers'] }}"
                                            data-namaCustomers="{{ $item['nama_customers'] }}"
                                            data-genderCustomers="{{ $item['gender_customers'] }}"
                                            data-tglLahirCustomers="{{ $item['tglLahir_customers'] }}"
                                            data-telpCustomers="{{ $item['telp_customers'] }}"
                                            data-emailCustomers="{{ $item['email_customers'] }}"
                                            data-alamatCustomers="{{ $item['alamat_customers'] }}"
                                            data-statusCustomers="{{ $item['status_customers'] }}">
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
    @extends('kasir.modal.member.addmember')
    @extends('kasir.modal.member.editmember')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            const d = new Date();
            const tanggal = `Data Member-${('0' + d.getDate()).slice(-2)}${('0' + (d.getMonth() + 1)).slice(-2)}${d.getFullYear()}`;
            $('#tableMember').DataTable({
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
