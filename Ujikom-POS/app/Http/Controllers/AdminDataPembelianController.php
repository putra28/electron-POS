<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class AdminDataPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // 1. Cek apakah user submit form dengan startdate dan enddate
            if ($request->has('startdate') && $request->has('enddate')) {
                $startDate = $request->input('startdate');
                $endDate = $request->input('enddate');
                $tanggal = $startDate . '_' . $endDate;

                // Simpan ke session
                session([
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'tanggal' => $tanggal
                ]);
            }

            // 2. Jika tidak ada input, ambil dari session atau default awal–akhir tahun
            if (!session()->has('tanggal')) {
                $startDate = Carbon::now()->startOfYear()->format('Y-m-d');
                $endDate = Carbon::now()->endOfYear()->format('Y-m-d');
                $tanggal = $startDate . '_' . $endDate;

                // Simpan ke session
                session([
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'tanggal' => $tanggal
                ]);
            } else {
                $tanggal = session('tanggal');
            }

            // 3. Ambil data dari API
            $url = config('api.base_url') . 'laporanpembelian';
            $supplierResponse = Http::get(config('api.base_url') . 'suppliers/');
            $produkResponse = Http::get(config('api.base_url') . 'produk/');

            $response = Http::get($url, [
                'tanggal' => $tanggal
            ]);

            $data_pembelian = $response->successful()
                ? $response->json('data')
                : [];

            $data_supplier = $supplierResponse->successful()
                ? $supplierResponse->json('data')
                : [];

            $data_produk = $produkResponse->successful()
                ? $produkResponse->json('data')
                : [];

            return view('admin.datapembelian', [
                'pembelian' => $data_pembelian,
                'supplier' => $data_supplier,
                'produk' => $data_produk,
                'tanggal' => $tanggal
            ]);
        } catch (\Exception $e) {
            return view('admin.datapembelian', [
                'pembelian' => [],
                'supplier' => [],
                'produk' => [],
                'tanggal' => '',
                'error' => 'Gagal mengambil data pembelian'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $idpembelian = $request->input('id_editpembelian');
            $totalHarga = (int) str_replace('.', '', $request->input('total_editpembelian'));

            $url = config('api.base_url') . "laporanpembelian/{$idpembelian}";
            $data = [
                'p_totalHarga'     => $totalHarga,
                'p_statusPembelian'   => $request->input('status_editpembelian'),
            ];
            // dd($data, $url);

            $response = Http::put($url, $data);

            if ($response['status'] === 200) {
                return redirect('admin/datapembelian')->with('success', $response['message']);
            } else {
                return redirect('admin/datapembelian')->with('error', 'Gagal mengubah status.');
            }
        } catch (\Exception $e) {
            return redirect('admin/datapembelian')->with('error', 'Terjadi kesalahan saat mengubah status');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id_deletepembelian' => 'required|numeric',
        ]);

        $idPembelian = $request->id_deletepembelian;

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->delete(config('api.base_url') . "laporanpembelian/{$idPembelian}");

            if ($response['status'] === 200) {
                return redirect('admin/datapembelian')->with('success', 'Riwayat berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'Gagal menghapus riwayat: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus riwayat: ' . $e->getMessage());
        }
    }
}

