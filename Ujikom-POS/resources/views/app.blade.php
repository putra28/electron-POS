<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @font-face {
            font-family: 'Outfit';
            src: url('/fonts/Outfit-Regular.ttf') format('truetype');
            /* Ganti Nama-Font-Regular.ttf dengan nama file font yang sesuai */
            font-weight: normal;
            font-style: normal;
        }

        @import '~bootstrap-icons/font/bootstrap-icons.css';

        .text-abu {
            color: #CCCCCC;
        }

        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Point Of Sale Putra</title>
    <!-- site icon -->
    <link rel="icon" href="{{ asset('images/logo/favicon.png') }}" type="image/png" />


    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.2/css/buttons.dataTables.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- DataTables JS Core + Buttons -->
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.dataTables.js"></script>

    <!-- Export dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Buttons for HTML5 and Print -->
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.print.min.js"></script>

    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ZingChart JS -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
</head>
@yield('styles')

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">

            <!-- Navbar -->
            <!-- Navbar -->
            @if (Session::has('tb_petugas') && Session::get('tb_petugas')['role_user'] == 'admin')
                @include('layouts.adminsidebar')
            @elseif(Session::has('tb_petugas') && Session::get('tb_petugas')['role_user'] == 'kasir')
                @include('layouts.sidebar')
            @endif
            <div class="col py-3">
                <!-- Main Content -->
                @yield('content')
            </div>
        </div>
    </div>
</body>
<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}'
        })
    @elseif (isset($success))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ $success }}'
        })

    @elseif(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}'
        })
    @elseif (isset($error))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ $error }}'
        })
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ $errors->first() }}'
        })
    @endif
</script>
@yield('scripts')
</html>
