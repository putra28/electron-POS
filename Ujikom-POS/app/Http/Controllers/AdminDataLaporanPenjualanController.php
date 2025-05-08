<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class AdminDataLaporanPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Ambil input tahun dari request, default ke tahun ini
            $tahun = $request->input('tahun', now()->year);
            session(['tahun' => $tahun]);

            // Set start dan end date dari tahun
            $startDate = Carbon::createFromDate($tahun, 1, 1)->format('Y-m-d');
            $endDate = Carbon::createFromDate($tahun, 12, 31)->format('Y-m-d');
            $tanggal = $startDate . '_' . $endDate;

            $url = config('api.base_url') . 'laporanPenjualan';

            $response = Http::get($url, [
                'tanggal' => $tanggal
            ]);

            if ($response->successful()) {
                $data_penjualan = $response->json('data');
                $totalKuantitas = 0;
                $totalPemasukan = 0;
                $totalPendapatan = 0;
                $produkTerlaris = [];

                foreach ($data_penjualan as $penjualan) {
                    $totalKuantitas += $penjualan['total_kuantitas'];
                    $totalPemasukan += (int) $penjualan['total_bayar'];
                    $totalPendapatan += (int) $penjualan['total_pendapatan'];

                    foreach ($penjualan['detail_penjualan'] as $detail) {
                        $namaProduk = $detail['produk']['nama_produk'];
                        $kuantitas = $detail['kuantitas'];
                        $subtotal = (int) $detail['subtotal'];

                        if (!isset($produkTerlaris[$namaProduk])) {
                            $produkTerlaris[$namaProduk] = [
                                'jumlah' => 0,
                                'total' => 0
                            ];
                        }

                        $produkTerlaris[$namaProduk]['jumlah'] += $kuantitas;
                        $produkTerlaris[$namaProduk]['total'] += $subtotal;
                    }
                }

                arsort($produkTerlaris);
                $namaProdukTerlaris = array_key_first($produkTerlaris);

                // Penjualan per karyawan
                $penjualanKaryawan = [];
                foreach ($data_penjualan as $penjualan) {
                    $namaKasir = $penjualan['karyawan']['nama_user'] ?? 'Tidak Diketahui';
                    $penjualanKaryawan[$namaKasir] = ($penjualanKaryawan[$namaKasir] ?? 0) + $penjualan['total_kuantitas'];
                }

                arsort($penjualanKaryawan);
                $karyawanTerbaik = array_key_first($penjualanKaryawan);

                // Chart per bulan
                $penjualanPerBulan = [];
                foreach ($data_penjualan as $penjualan) {
                    $bulan = Carbon::parse($penjualan['tanggal_penjualan'])->format('Y-m');
                    $penjualanPerBulan[$bulan] = ($penjualanPerBulan[$bulan] ?? 0) + (int) $penjualan['total_bayar'];
                }
                ksort($penjualanPerBulan);

                // Buat data bulan dari Januari - Desember
                $chart_labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

                // Lakukan mapping agar data array bulan jadi array sesuai urutan bulan
                $chart_penjualan = [];

                for ($i = 1; $i <= 12; $i++) {
                    $key = $tahun . '-' . str_pad($i, 2, '0', STR_PAD_LEFT); // contoh: "2025-01"
                    $chart_penjualan[] = $penjualanPerBulan[$key] ?? 0;
                }

                return view('admin.datalaporanpenjualan', [
                    'penjualan' => $data_penjualan,
                    'tanggal' => $tanggal,
                    'total_kuantitas' => $totalKuantitas,
                    'total_pemasukan' => $totalPemasukan,
                    'total_keuntungan' => $totalPendapatan,
                    'produk_terlaris' => $produkTerlaris,
                    'nama_produk_terlaris' => $namaProdukTerlaris,
                    'karyawan_terbaik' => $karyawanTerbaik,
                    'chart_labels' => $chart_labels,
                    'chart_values' => $chart_penjualan,
                    'tahun' => $tahun
                ]);
            } else {
                return view('admin.datalaporanpenjualan', [
                    'penjualan' => [],
                    'tanggal' => $tanggal,
                    'total_kuantitas' => 0,
                    'total_pemasukan' => 0,
                    'total_keuntungan' => 0,
                    'produk_terlaris' => [],
                    'nama_produk_terlaris' => '',
                    'karyawan_terbaik' => '',
                    'chart_labels' => [],
                    'chart_values' => [],
                    'tahun' => $tahun
                ]);
            }
        } catch (\Exception $e) {
            return view('admin.datalaporanpenjualan', [
                'penjualan' => [],
                'tanggal' => [],
                'error' => 'Gagal mengambil data penjualan',
                'tahun' => now()->year
            ]);
        }
    }
}

