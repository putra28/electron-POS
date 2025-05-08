<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class AdminDataLaporanPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Definisikan urutan dan nama kategori pengeluaran
        $jenis_pengeluaran_list = [
            'Pembelian Produk ke Supplier',
            'Gaji & Tunjangan',
            'Operasional Toko',
            'Sewa & Perawatan',
            'Peralatan & Inventaris',
            'Promosi & Iklan',
            'Transportasi & Pengiriman',
            'Pajak & Perizinan',
            'Biaya Keuangan',
            'Biaya Lain-lain'
        ];

        try {
            $tahun = $request->input('tahun', now()->year);
            session(['tahun' => $tahun]);

            $startDate = Carbon::createFromDate($tahun, 1, 1)->format('Y-m-d');
            $endDate = Carbon::createFromDate($tahun, 12, 31)->format('Y-m-d');
            $tanggal = $startDate . '_' . $endDate;

            // Fetch API
            $penjualanRes = Http::get(config('api.base_url') . 'laporanPenjualan', ['tanggal' => $tanggal]);
            $pembelianRes = Http::get(config('api.base_url') . 'laporanPembelian');
            $pengeluaranRes = Http::get(config('api.base_url') . 'laporanPengeluaran');

            // Check success
            if (!$penjualanRes->successful() || !$pembelianRes->successful() || !$pengeluaranRes->successful()) {
                throw new \Exception("Gagal fetch salah satu API");
            }

            $data_penjualan = $penjualanRes->json('data');
            $data_pembelian = $pembelianRes->json('data');
            $data_pengeluaran = $pengeluaranRes->json('data');

            // Inisialisasi variabel
            $totalPendapatan = 0;
            $totalBayar = 0;
            $totalTransaksi = count($data_penjualan);

            foreach ($data_penjualan as $penjualan) {
                $totalBayar += (int) $penjualan['total_bayar'];
                $totalPendapatan += (int) $penjualan['total_pendapatan'];
            }

            // Hitung Total HPP (dari pembelian produk)
            $totalHPP = 0;
            $totalPembelian = 0;
            foreach ($data_pembelian as $pembelian) {
                $totalHPP += (int) $pembelian['total_harga'];
                $totalPembelian++; // untuk total transaksi pembelian
            }

            // Hitung Pengeluaran lain (kategori != 'Pembelian Produk ke Supplier')
            $totalPengeluaranLain = 0;
            foreach ($data_pengeluaran as $pengeluaran) {
                if ($pengeluaran['nama_kategori_pengeluaran'] !== 'Pembelian Produk ke Supplier') {
                    $totalPengeluaranLain += (int) $pengeluaran['total_pengeluaran'];
                }
            }

            // Hitung Laba Kotor & Laba Bersih
            $labaKotor = $totalPendapatan - $totalHPP;
            $labaBersih = $labaKotor - $totalPengeluaranLain;

            // Untuk chart: perbandingan total penjualan vs total pengeluaran
            $totalPengeluaran = $totalHPP + $totalPengeluaranLain;

            // Inisialisasi array total pengeluaran berdasarkan jenis, default = 0
            $pengeluaran_per_jenis = array_fill(0, count($jenis_pengeluaran_list), 0);

            // Mapping nama ke index
            $jenis_pengeluaran_index_map = array_flip($jenis_pengeluaran_list);

            // Loop data pengeluaran dan jumlahkan berdasarkan kategori
            foreach ($data_pengeluaran as $pengeluaran) {
                $nama_kategori = $pengeluaran['nama_kategori_pengeluaran'];
                $jumlah = (int) $pengeluaran['total_pengeluaran'];

                if (isset($jenis_pengeluaran_index_map[$nama_kategori])) {
                    $index = $jenis_pengeluaran_index_map[$nama_kategori];
                    $pengeluaran_per_jenis[$index] += $jumlah;
                }
            }

            // Chart Penjualan per bulan
            $penjualanPerBulan = [];
            foreach ($data_penjualan as $penjualan) {
                $bulan = Carbon::parse($penjualan['tanggal_penjualan'])->format('Y-m');
                $penjualanPerBulan[$bulan] = ($penjualanPerBulan[$bulan] ?? 0) + (int) $penjualan['total_bayar'];
            }
            ksort($penjualanPerBulan);

            // Chart Pengeluaran per bulan
            $pengeluaranPerBulan = [];
            foreach ($data_pengeluaran as $pengeluaran) {
                $bulan = Carbon::parse($pengeluaran['tanggal'])->format('Y-m');
                $pengeluaranPerBulan[$bulan] = ($pengeluaranPerBulan[$bulan] ?? 0) + (int) $pengeluaran['total_pengeluaran'];
            }
            ksort($pengeluaranPerBulan);

            // Buat data bulan dari Januari - Desember
            $chart_labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

            // Lakukan mapping agar data array bulan jadi array sesuai urutan bulan
            $chart_penjualan = [];
            $chart_pengeluaran = [];

            for ($i = 1; $i <= 12; $i++) {
                $key = $tahun . '-' . str_pad($i, 2, '0', STR_PAD_LEFT); // contoh: "2025-01"
                $chart_penjualan[] = $penjualanPerBulan[$key] ?? 0;
                $chart_pengeluaran[] = $pengeluaranPerBulan[$key] ?? 0;
            }

            return view('admin.datalaporanpengeluaran', [
                'penjualan' => $data_penjualan,
                'tanggal' => $tanggal,
                'total_pemasukan' => $totalBayar,
                'total_pendapatan' => $totalPendapatan,
                'total_hpp' => $totalHPP,
                'laba_kotor' => $labaKotor,
                'pengeluaran_lain' => $totalPengeluaranLain,
                'laba_bersih' => $labaBersih,
                'total_pembelian_barang' => $totalHPP,
                'total_transaksi_penjualan' => $totalTransaksi,
                'total_transaksi_pembelian' => $totalPembelian,
                'chart_labels' => $chart_labels,
                'chart_penjualan' => $chart_penjualan,
                'chart_pengeluaran' => $chart_pengeluaran,
                'pengeluaran_per_jenis' => $pengeluaran_per_jenis,
                'jenis_pengeluaran_list' => $jenis_pengeluaran_list,
                'tahun' => $tahun
            ]);
        } catch (\Exception $e) {
            return view('admin.datalaporanpengeluaran', [
                'penjualan' => [],
                'tanggal' => [],
                'error' => 'Gagal mengambil data laporan',
                'tahun' => now()->year
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
