<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class AdminDataLaporanStokController extends Controller
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
                $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
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

            // Kirim request ke API dengan parameter tanggal (periode)
            $response = Http::get(config('api.base_url') . 'laporanstok', [
                'tanggal' => $tanggal
            ]);

            $groupedLaporan = [];

            if ($response['status'] === 200) {
                $data = $response['data'];

                foreach ($data as $item) {
                    $kode = $item['kode_laporan'];

                    if (!isset($groupedLaporan[$kode])) {
                        $groupedLaporan[$kode] = [
                            'kode_laporan' => $kode,
                            'alasan_perubahan' => $item['alasan_perubahan'],
                            'nama_karyawan' => $item['nama_karyawan'],
                            'created_at' => $item['created_at'],
                            'produk' => [],
                            'ids' => [],
                        ];
                    }

                    $groupedLaporan[$kode]['produk'][] = [
                        'nama_produk' => $item['nama_produk'],
                        'perubahan_stok' => $item['perubahan_stok']
                    ];

                    $groupedLaporan[$kode]['ids'][] = $item['id_laporan_stok'];
                }
            }

            return view('admin.datalaporanstok', [
                'laporanstok' => array_values($groupedLaporan)
            ]);

        } catch (\Exception $e) {
            return view('admin.datalaporanstok', [
                'laporanstok' => [],
                'error' => 'Gagal mengambil data laporan stok produk'
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
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id_deleteLaporan' => 'required|numeric',
        ]);

        $idLaporan = $request->id_deleteLaporan;

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->delete(config('api.base_url') . "laporanstok/{$idLaporan}");

            if ($response['status'] === 200) {
                return redirect('admin/datastokproduk')->with('success', 'Laporan berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'Gagal menghapus laporan: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus laporan: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        foreach ($ids as $id) {
            Http::delete(config('api.base_url') . "laporanstok/$id");
        }

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }
}
