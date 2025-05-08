<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
        <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img src="{{ URL::asset('images/logo/favicon.png') }}" alt="Logo_Kasir" height="50" width="70">
            <span class="fs-3 d-none d-sm-inline text-abu"><b>PKK SALE</b></span>
        </a>
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item">
                <a href="{{ URL('/kasir/dashboard') }}" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-speedometer2 text-abu"></i> <span
                        class="ms-1 d-none d-sm-inline text-abu">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ URL('/kasir/transaksi') }}" class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-cart text-abu"></i> <span
                        class="ms-1 d-none d-sm-inline text-abu">Transaksi</span></a>
            </li>
            <li>
                <a href="#submenuMember" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                    <i class="fa-solid fa-users text-abu"></i> <span class="ms-1 d-none d-sm-inline text-abu">Member</span></a>
                <ul class="collapse nav flex-column ms-4" id="submenuMember" data-bs-parent="#menu">
                    <li>
                        <a href="#" class="nav-link px-0 align-middle" data-bs-toggle="modal" data-bs-target="#addmemberModal">
                            <span class="ms-1 d-none d-sm-inline text-abu">Tambah
                                Member</span></a>
                    </li>
                    <li>
                        <a href="{{ URL('/kasir/datamember') }}" class="nav-link px-0 text-abu">
                            <span class="ms-1 d-none d-sm-inline text-abu">Data Member</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#submenutabel" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                    <i class="fa-solid fa-list text-abu"></i> <span class="ms-1 d-none d-sm-inline text-abu">Tabel
                        Data</span></a>
                <ul class="collapse nav flex-column ms-4" id="submenutabel" data-bs-parent="#menu">
                    <li class="w-100">
                        <a href="{{ URL('/kasir/dataproduk') }}" class="nav-link px-0 text-abu">
                            <span class="ms-1 d-none d-sm-inline text-abu">Data
                                Produk</span></a>
                    </li>
                    <li>
                        <a href="{{ URL('/kasir/riwayattransaksi') }}" class="nav-link px-0 text-abu">
                            <span class="ms-1 d-none d-sm-inline text-abu">Riwayat Transaksi</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#submenuIzin" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                    <i class="fa-solid fa-file-pen text-abu"></i> <span class="ms-1 d-none d-sm-inline text-abu">Pengajuan Izin</span></a>
                <ul class="collapse nav flex-column ms-4" id="submenuIzin" data-bs-parent="#menu">
                    <li class="w-100">
                        <a href="{{ URL('/kasir/izinkaryawan') }}" class="nav-link px-0 text-abu">
                            <span class="ms-1 d-none d-sm-inline text-abu">Izin
                                Karyawan</span></a>
                    </li>
                </ul>
            </li>
        </ul>
        <hr class="dropdown-divider">
        <div class="dropdown pb-4">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ session('foto_petugas') ? session('foto_petugas') : 'https://placehold.co/200' }}"
                                alt="Foto Petugas" class="rounded-circle" height="30" width="30">
                <span class="d-none d-sm-inline mx-1">{{ Session::has('tb_petugas') ? Session::get('tb_petugas')['nama_user'] : 'Nama Petugas' }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li>
                    <form action="{{ URL::asset('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item">Sign Out</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
