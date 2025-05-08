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
            <h3>Data Supplier</h3>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addsupplierModal">Add Data Supplier</button>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tableSupplier">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>ID Supplier</th>
                                <th>Nama Supplier</th>
                                <th>Contact Person</th>
                                <th>Contact Supplier</th>
                                <th>Email Supplier</th>
                                <th>Alamat Supplier</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suppliers as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item['id_suppliers'] }}</td>
                                <td>{{ $item['nama_suppliers'] }}</td>
                                <td>{{ $item['contact_person'] }}</td>
                                <td>{{ $item['contact_suppliers'] }}</td>
                                <td>{{ $item['email_suppliers'] }}</td>
                                <td>{{ $item['alamat_suppliers'] }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editsupplierModal"
                                            data-idsupplier="{{ $item['id_suppliers'] }}"
                                            data-namasupplier="{{ $item['nama_suppliers'] }}"
                                            data-contactperson="{{ $item['contact_person'] }}"
                                            data-contactsupplier="{{ $item['contact_suppliers'] }}"
                                            data-emailsupplier="{{ $item['email_suppliers'] }}"
                                            data-alamatsupplier="{{ $item['alamat_suppliers'] }}">
                                            Edit
                                        </button>
                                        <button class="btn btn-danger w-100 deleteSwal"
                                            data-idsupplier="{{ $item['id_suppliers'] }}"
                                            data-namasupplier="{{ $item['nama_suppliers'] }}"
                                            data-action="{{ route('admin.datasupplier.delete', $item['id_suppliers']) }}">
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
    @extends('admin.modal.supplier.addsupplier')
    @extends('admin.modal.supplier.editsupplier')
    @extends('admin.modal.supplier.deletesupplier')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            const d = new Date();
            const tanggal = `Data Supplier-${('0' + d.getDate()).slice(-2)}${('0' + (d.getMonth() + 1)).slice(-2)}${d.getFullYear()}`;
            $('#tableSupplier').DataTable({
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
