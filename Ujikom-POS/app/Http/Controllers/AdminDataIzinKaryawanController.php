<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminDataIzinKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $izinResponse = Http::get(config('api.base_url') . 'laporanIzinKaryawan/');
            $kategoriResponse = Http::get(config('api.base_url') . 'kategoriIzin/');

            if ($izinResponse['status'] === 200 && $kategoriResponse['status'] === 200) {
                return view('admin.dataizin', [
                    'izinKaryawan' => $izinResponse['data'],
                    'kategoriIzin' => $kategoriResponse['data']
                ]);
            }
        } catch (\Exception $e) {
            return view('admin.dataizin', [
                'izinKaryawan' => [],
                'kategoriIzin' => [],
                'error' => 'Gagal mengambil data izin karyawan atau kategori izin'
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
    public function storeKategoriIzin(Request $request)
    {
        try {
            $data = [
                'p_namaKategoriIzin'     => $request->input('kategoriIzin_addIzin'),
            ];

            $response = Http::post(config('api.base_url') . 'kategoriIzin/', $data);

            if ($response['status'] === 200) {
                return redirect('admin/dataizinkaryawan')->with('success', 'Kategori Izin berhasil ditambahkan.');
            } else {
                return redirect('admin/dataizinkaryawan')->with('error', 'Gagal menambahkan kategori.');
            }
        } catch (\Exception $e) {
            return redirect('admin/dataizinkaryawan')->with('error', 'Terjadi kesalahan saat menambahkan kategori');
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
                'p_startDate'   => $request->input('startDate_editIzinn'),
                'p_endDate' => $request->input('endDate_editIzinn'),
                'p_status'     => $request->input('statusIzin_editIzin'),
            ];

            $response = Http::put($url, $data);

            if ($response['status'] === 200) {
                return redirect('admin/dataizinkaryawan')->with('success', $response['message']);
            } else {
                return redirect('admin/dataizinkaryawan')->with('error', 'Gagal mengubah pengajuan.');
            }
        } catch (\Exception $e) {
            return redirect('admin/dataizinkaryawan')->with('error', 'Terjadi kesalahan saat mengubah pengajuan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id_deletemember' => 'required|numeric',
        ]);

        $idCustomers = $request->id_deletemember;

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->delete(config('api.base_url') . "laporanIzinKaryawan/{$idCustomers}");

            if ($response['status'] === 200) {
                return redirect('admin/dataizinkaryawan')->with('success', 'Laporan berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'Gagal menghapus laporan: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus laporan: ' . $e->getMessage());
        }
    }

    public function destroyKategoriIzin(Request $request)
    {
        $request->validate([
            'id_deleteKategoriIzin' => 'required|numeric',
        ]);

        $idKategoriIzin = $request->id_deleteKategoriIzin;

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->delete(config('api.base_url') . "kategoriIzin/{$idKategoriIzin}");

            if ($response['status'] === 200) {
                return redirect('admin/dataizinkaryawan')->with('success', 'Kategori berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'Gagal menghapus kategori: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kategori: ' . $e->getMessage());
        }
    }
}

