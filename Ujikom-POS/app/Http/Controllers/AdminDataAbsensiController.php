<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminDataAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $absensiResponse = Http::get(config('api.base_url') . 'laporanabsen/');

            if ($absensiResponse['status'] === 200) {
                return view('admin.dataabsensi', [
                    'absensi' => $absensiResponse['data']
                ]);
            }
        } catch (\Exception $e) {
            return view('admin.dataabsensi', [
                'absensi' => [],
                'error' => 'Gagal mengambil data kehadiran'
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id_deleteabsensi' => 'required',
        ]);

        $id = $request->id_deleteabsensi;

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->delete(config('api.base_url') . "laporanabsen/{$id}");

            if ($response['status'] === 200) {
                return redirect('admin/dataabsensi')->with('success', 'Data berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}

