<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class KasirTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Ambil data kategori dari API
            $kategoriResponse = Http::get(config('api.base_url') . 'kategori/');
            $data_kategori = $kategoriResponse->successful() ? $kategoriResponse->json('data') : [];

            // Ambil data produk dari API
            $produkResponse = Http::get(config('api.base_url') . 'produk/');
            $data_produk = $produkResponse->successful() ? $produkResponse->json('data') : [];

            // Ambil data member/customer dari API
            $memberResponse = Http::get(config('api.base_url') . 'customer/');
            $data_member = $memberResponse->successful() ? $memberResponse->json('data') : [];

            return view('kasir.transaksi', [
                'data_kategori' => $data_kategori,
                'data_produk' => $data_produk,
                'data_member' => $data_member
            ]);
        } catch (\Exception $e) {
            return view('kasir.transaksi', [
                'data_kategori' => [],
                'data_produk' => [],
                'data_member' => [],
                'error' => 'Gagal mengambil data produk: ' . $e->getMessage()
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
        try {
            // Ambil data dari session
            $sessionUser = session('tb_petugas');
            $id_karyawan = $sessionUser['data_user']['id_karyawan'] ?? null;

            // Ambil request data
            $id_customer = (int) $request->input('member_transaksi');
            $total_harga = (int) $request->input('totalharga_transaksi');
            $total_bayar = (int) $request->input('totalbayar_transaksi');
            $total_kembalian = (int) $request->input('kembalian_transaksi');
            $cartData = json_decode($request->input('cartData'), true);

            // Buat tanggal sekarang
            $tanggal = Carbon::now()->format('Y-m-d H:i:s');

            // Format detail produk
            $detailPenjualan = collect($cartData)->map(function ($item) {
                return [
                    'p_idProduk' => (int) $item['namaproduk_transaksi'], // pastikan ini ID produk
                    'p_kuantitas' => (int) $item['kuantitas_transaksi'],
                    'p_harga' => (int) $item['hargaproduk_transaksi'],
                    'p_subTotal' => (int) ($item['hargaproduk_transaksi'] * $item['kuantitas_transaksi']),
                    'p_diskonProduk' => (int) $item['potongan_transaksi'],
                ];
            })->toArray();

            // Bangun body request API
            $body = [
                'p_idCustomers' => $id_customer,
                'p_idKaryawan' => $id_karyawan,
                'p_totalHarga' => $total_harga,
                'p_totalBayar' => $total_bayar,
                'p_totalKembalian' => $total_kembalian,
                'p_diskon' => 0,
                'p_tanggal' => $tanggal,
                'p_detailPenjualan' => $detailPenjualan
            ];

            // Kirim ke API
            $response = Http::post(config('api.base_url') . 'laporanPenjualan/', $body);

            if ($response->successful()) {
                $kode_penjualan = $response->json()['data']['kode_penjualan'] ?? null;

                // Kirim laporan pengurangan stok untuk setiap produk yang terjual
                foreach ($detailPenjualan as $item) {
                    Http::post(config('api.base_url') . 'laporanStok', [
                        'p_kodeLaporan' => $kode_penjualan,
                        'p_idProduk' => $item['p_idProduk'],
                        'p_namaKaryawan' => $sessionUser['nama_user'], // pastikan field ini sesuai dengan backend
                        'p_perubahanStok' => -abs($item['p_kuantitas']), // negatif karena pengurangan
                        'p_alasanPerubahan' => 'Penjualan Produk',
                    ]);
                }
                return redirect()->back()->with('success', 'Transaksi berhasil!');
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $response->body());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function printInvoice(Request $request)
    {
        // Ambil data dari URL
        $noNota = $request->input('noNota');
        $cartData = $request->input('cartData');
        $totalHarga = $request->input('totalHarga');

        // Tampilkan halaman cetak dengan membawa data yang diperlukan
        return view('kasir.print', compact('noNota', 'cartData', 'totalHarga'));
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

