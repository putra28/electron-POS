<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class KasirDataIzinKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Ambil ID petugas dari session
            $id_petugas = Session::get('tb_petugas')['data_user']['id_karyawan'];
            $izinResponse = Http::get(config('api.base_url') . 'laporanIzinKaryawan/' . $id_petugas);
            $kategoriResponse = Http::get(config('api.base_url') . 'kategoriIzin/');

            if ($izinResponse['status'] === 200 && $kategoriResponse['status'] === 200) {
                return view('kasir.dataizin', [
                    'izinKaryawan' => $izinResponse['data'],
                    'kategoriIzin' => $kategoriResponse['data']
                ]);
            }
        } catch (\Exception $e) {
            return view('kasir.dataizin', [
                'izinKaryawan' => [],
                'kategoriIzin' => [],
                'error' => 'Gagal mengambil data izin karyawan atau kategori izin'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $id_petugas = Session::get('tb_petugas')['data_user']['id_karyawan'];
            $data = [
                'p_idKaryawan'     => $id_petugas,
                'p_idJenisIzin'     => $request->input('kategori_addIzin'),
                'p_startDate'     => $request->input('startDate_addIzin'),
                'p_endDate'     => $request->input('endDate_addIzin'),
            ];
            // dd($data);

            $response = Http::post(config('api.base_url') . 'laporanIzinKaryawan/', $data);

            if ($response['status'] === 200) {
                return redirect('kasir/izinkaryawan')->with('success', 'Pengajuan Izin berhasil dikirimkan.');
            } else {
                return redirect('kasir/izinkaryawan')->with('error', 'Gagal mengirim pengajuan.');
            }
        } catch (\Exception $e) {
            return redirect('kasir/izinkaryawan')->with('error', 'Terjadi kesalahan saat mengirim pengajuan');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $id = $request->input('idIzin_editIzin');

            $url = config('api.base_url') . "laporanIzinKaryawan/{$id}";
            $data = [
                'p_startDate'   => $request->input('startDate_editIzin'),
                'p_endDate' => $request->input('endDate_editIzin'),
                'p_status'     => $request->input('statusIzin_editIzin'),
            ];

            $response = Http::put($url, $data);

            if ($response['status'] === 200) {
                return redirect('kasir/izinkaryawan')->with('success', $response['message']);
            } else {
                return redirect('kasir/izinkaryawan')->with('error', 'Gagal mengubah pengajuan.');
            }
        } catch (\Exception $e) {
            return redirect('kasir/izinkaryawan')->with('error', 'Terjadi kesalahan saat mengubah pengajuan');
        }
    }
}

