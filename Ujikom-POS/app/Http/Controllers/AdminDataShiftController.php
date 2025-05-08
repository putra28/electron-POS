<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminDataShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Ambil data customer dari API eksternal
            $response = Http::get(config('api.base_url') . 'shifts/');

            if ($response['status'] === 200) {
                $get_shift = $response['data']; // ambil array data dari JSON
            } else {
                $get_shift = []; // fallback kosong kalau gagal
            }

            return view('admin.datajadwalshift', [
                'shifts' => $get_shift
            ]);
        } catch (\Exception $e) {
            return view('admin.datajadwalshift', [
                'shifts' => [],
                'error' => 'Gagal mengambil data jadwal shift'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'jadwal_addshift'        => 'required',
                'startTime_addshift'        => 'required|date_format:H:i',
                'endTime_addshift'        => 'required|date_format:H:i',
            ]);

            $data = [
                'p_namaShifts'         => $request->jadwal_addshift,
                'p_startTime'         => $request->startTime_addshift . ':00',
                'p_endTime'         => $request->endTime_addshift . ':00',
            ];

            $response = Http::post(config('api.base_url') . 'shifts/', $data);

            if ($response['status'] === 200) {
                return redirect('admin/datashift')->with('success', 'Jadwal berhasil ditambahkan.');
            }

            return redirect()->back()->with('error', 'Gagal menambahkan jadwal: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan jadwal: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request)
    {
        function normalizeTime($time) {
            $parts = explode(':', $time);

            if (count($parts) === 2) {
                // Format HH:MM → tambahkan detik
                return $time . ':00';
            } elseif (count($parts) === 1) {
                // Format HH → tambahkan menit dan detik
                return $time . ':00:00';
            }

            // Sudah HH:MM:SS
            return $time;
        }

        try {
            $request->validate([
                'id_editshift'        => 'required',
                'jadwal_editshift'        => 'required',
                'startTime_editshift'        => 'required',
                'endTime_editshift'        => 'required',
            ]);

            $id = $request->id_editshift;
            $startTime = normalizeTime($request->startTime_editshift);
            $endTime = normalizeTime($request->endTime_editshift);
            $url = config('api.base_url') . "shifts/{$id}";

            $data = [
                'p_namaShifts'         => $request->jadwal_editshift,
                'p_startTime'         => $startTime,
                'p_endTime'         => $endTime,
            ];

            $response = Http::put($url, $data);

            if ($response['status'] === 200) {
                return redirect('admin/datashift')->with('success', 'Jadwal berhasil diperbarui.');
            }

            return redirect()->back()->with('error', 'Gagal memperbarui jadwal: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui jadwal: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id_deleteshift' => 'required|numeric',
        ]);

        $idShift = $request->id_deleteshift;

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->delete(config('api.base_url') . "shifts/{$idShift}");

            if ($response['status'] === 200) {
                return redirect('admin/datashift')->with('success', 'Jadwal berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'Gagal menghapus jadwal: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus jadwal: ' . $e->getMessage());
        }
    }
}

