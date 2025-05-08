<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Ambil tanggal awal dan akhir bulan ini
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
            $tanggal = $startDate . '_' . $endDate;

            // Ambil data produk
            $produkResponse = Http::get(config('api.base_url') . 'produk/');
            $get_produk = $produkResponse->successful() ? $produkResponse->json('data') : [];

            // Ambil data kategori
            $kategoriResponse = Http::get(config('api.base_url') . 'kategori/');
            $get_kategori = $kategoriResponse->successful() ? collect($kategoriResponse->json('data')) : collect([]);

            // Filter kategori unik berdasarkan id_kategori
            $kategori_unik = $get_kategori->unique('id_kategori');

            // Ambil data penjualan (periode hari ini default)
            $penjualanResponse = Http::get(config('api.base_url') . 'laporanPenjualan', [
                'tanggal' => $tanggal
            ]);
            $get_penjualanperiode = $penjualanResponse->successful() ? $penjualanResponse->json('data') : [];

            // Hitung total data penjualan
            $total_data = count($get_penjualanperiode);
            $total_produk = count($get_produk);

            // Total nilai penjualan
            $total_penjualan = collect($get_penjualanperiode)->sum(function ($item) {
                return (int)$item['total_harga'];
            });

            return view('kasir.dashboard', [
                'penjualan' => $get_penjualanperiode,
                'periodepenjualan' => $total_data,
                'totalpenjualan' => $total_penjualan,
                'totalproduk' => $total_produk,
                'kategori' => $get_kategori,
                'kategori_unik' => $kategori_unik
            ]);
        } catch (\Exception $e) {
            return view('kasir.dashboard', [
                'penjualan' => [],
                'periodepenjualan' => 0,
                'totalpenjualan' => 0,
                'totalproduk' => 0,
                'kategori' => collect([]),
                'kategori_unik' => collect([]),
                'error' => 'Gagal mengambil data dashboard: ' . $e->getMessage()
            ]);
        }
    }
}

