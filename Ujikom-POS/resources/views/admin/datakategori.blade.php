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
            <h3>Data Kategori Produk</h3>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addkategoriModal">Add Data Produk</button>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tableKategori">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>Nama Kategori</th>
                                <th>Sub-Kategori</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategori as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item['nama_kategori'] }}</td>
                                <td>
                                    <ul>
                                        @foreach($item['data_subkategori'] as $sub)
                                        <li>{{ $sub['nama_subkategori'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editkategoriModal"
                                        data-idkategori="{{ $item['id_kategori'] }}" data-namakategori="{{ $item['nama_kategori'] }}" data-subkategori='@json($item['data_subkategori'])'>
                                            Edit
                                        </button>
                                        <button class="btn btn-danger w-100 deleteSwal"
                                        data-idkategori="{{ $item['id_kategori'] }}" data-namakategori="{{ $item['nama_kategori'] }}"
                                        data-action="{{ route('admin.datakategori.delete', $item['id_kategori']) }}">Delete</button>
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
    @extends('admin.modal.kategori.addkategori')
    @extends('admin.modal.kategori.editkategori')
    @extends('admin.modal.kategori.deletekategori')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            const d = new Date();
            const tanggal = `Data Kategori Produk-${('0' + d.getDate()).slice(-2)}${('0' + (d.getMonth() + 1)).slice(-2)}${d.getFullYear()}`;
            $('#tableKategori').DataTable({
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
