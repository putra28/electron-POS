<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class AdminDataPengeluaranController extends Controller
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
            $url = config('api.base_url') . "laporanPengeluaran";
            $kategoriResponse = Http::get(config('api.base_url') . "kategoriPengeluaran/");

            $response = Http::get($url, [
                'tanggal' => $tanggal
            ]);

            $data_pengeluaran = $response->successful()
                ? $response->json('data')
                : [];

            $data_kategori = $kategoriResponse->successful()
                ? $kategoriResponse->json('data')
                : [];

            return view('admin.datapengeluaran', [
                'pengeluaran' => $data_pengeluaran,
                'kategori_pengeluaran' => $data_kategori,
                'tanggal' => $tanggal
            ]);
        } catch (\Exception $e) {
            return view('admin.datapengeluaran', [
                'pengeluaran' => [],
                'kategori_pengeluaran' => [],
                'tanggal' => '',
                'error' => 'Gagal mengambil data pengeluaran'
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
            $request->validate([
                'kategori_addPengeluaran'        => 'required',
                'total_addPengeluaran'        => 'required',
                'tanggal_addPengeluaran'        => 'required',
                'deskripsi_addPengeluaran'        => 'required',
            ]);

            $data = [
                'p_idKategoriPengeluaran'         => $request->kategori_addPengeluaran,
                'p_totalPengeluaran'         => $request->total_addPengeluaran,
                'p_deskripsiPengeluaran'         => $request->deskripsi_addPengeluaran,
                'p_tanggal'         => Carbon::createFromFormat('Y-m-d', $request->tanggal_addPengeluaran)
                                        ->setTimeFromTimeString(now()->toTimeString())
                                        ->format('Y-m-d H:i:s'),
            ];

            $response = Http::post(config('api.base_url') . "laporanPengeluaran/", $data);

            if ($response['status'] === 200) {
                return redirect('admin/datapengeluaran')->with('success', 'Data berhasil ditambahkan.');
            }

            return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'id_editPengeluaran'        => 'required',
                'kategori_editPengeluaran'        => 'required',
                'total_editPengeluaran'        => 'required',
                'tanggal_editPengeluaran'        => 'required',
                'deskripsi_editPengeluaran'        => 'required',
            ]);

            $idPengeluaran = $request->id_editPengeluaran;

            $data = [
                'p_idKategoriPengeluaran'         => $request->kategori_editPengeluaran,
                'p_totalPengeluaran'         => $request->total_editPengeluaran,
                'p_deskripsiPengeluaran'         => $request->deskripsi_editPengeluaran,
                'p_tanggal'         => Carbon::createFromFormat('Y-m-d', $request->tanggal_editPengeluaran)
                                        ->setTimeFromTimeString(now()->toTimeString())
                                        ->format('Y-m-d H:i:s'),
            ];

            $url = config('api.base_url') . "laporanPengeluaran/{$idPengeluaran}";

            $response = Http::put($url, $data);

            if ($response['status'] === 200) {
                return redirect('admin/datapengeluaran')->with('success', 'Data berhasil diubah.');
            }

            return redirect()->back()->with('error', 'Gagal mengubah data: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id_deletePengeluaran' => 'required|numeric',
        ]);

        $idPengeluaran = $request->id_deletePengeluaran;

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->delete(config('api.base_url') . "laporanpengeluaran/{$idPengeluaran}");

            if ($response['status'] === 200) {
                return redirect('admin/datapengeluaran')->with('success', 'Data berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
