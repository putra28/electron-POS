<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class KasirDataTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $id_karyawan = session('tb_petugas') ? session('tb_petugas')['data_user']['id_karyawan'] : null;
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
            $url = config('api.base_url') . 'laporanPenjualan';

            $response = Http::get($url, [
                'tanggal' => $tanggal
            ]);

            $data_penjualan = $response->successful()
                ? $response->json('data')
                : [];

            return view('admin.datapenjualan', [
                'penjualan' => $data_penjualan,
                'tanggal' => $tanggal
            ]);
        } catch (\Exception $e) {
            return view('admin.datapenjualan', [
                'penjualan' => [],
                'tanggal' => '',
                'error' => 'Gagal mengambil data penjualan'
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

