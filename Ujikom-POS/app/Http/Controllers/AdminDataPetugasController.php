<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\HttpHelper;

class AdminDataPetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $karyawanResponse = Http::get(config('api.base_url') . 'karyawan/');
            $shiftsResponse = Http::get(config('api.base_url') . 'shifts/');

            if ($karyawanResponse['status'] === 200) {
                return view('admin.datapetugas', [
                    'petugas' => $karyawanResponse['data'],
                    'shifts' => $shiftsResponse['data']
                ]);
            } else {
                return view('admin.datapetugas', [
                    'petugas' => [],
                    'shifts' => [],
                    'error' => 'Gagal mengambil data dari API',
                ]);
            }
        } catch (\Exception $e) {
            return view('admin.datapetugas', [
                'petugas' => [],
                'shifts' => [],
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'contact_addpetugas' => 'required|numeric',
            'password_addpetugas' => 'required',
            'nama_addpetugas' => 'required',
            'role_addpetugas' => 'required',
            'posisi_addpetugas' => 'required',
            'gaji_addpetugas' => 'required|numeric',
            'alamat_addpetugas' => 'required',
            'shift_addpetugas' => 'required|numeric',
            'foto_addpetugas' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            // Payload lengkap ke satu endpoint
            $payload = [
                'p_namaUsers'       => $request->nama_addpetugas,
                'p_contactUsers'    => $request->contact_addpetugas,
                'p_passwordUsers'   => $request->password_addpetugas,
                'p_roleUsers'       => $request->role_addpetugas,
                'p_posisiKaryawan'  => $request->posisi_addpetugas,
                'p_gajiKaryawan'    => $request->gaji_addpetugas,
                'p_alamatKaryawan'  => $request->alamat_addpetugas,
                'p_idShifts'        => $request->shift_addpetugas,
            ];

            $response = HttpHelper::postMultipart(
                config('api.base_url') . 'karyawan',
                $payload,
                'p_gambarUser',
                $request->file('foto_addpetugas')
            );

            if (!$response['status'] === 200) {
                return back()->with('error', 'Gagal menambahkan data petugas');
            }

            return redirect('/admin/datapetugas')->with('success', 'Data petugas berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        // Validate the request...
        $request->validate([
            'id_editpetugas' => 'required|numeric',
            'idUser_editpetugas' => 'required|numeric',
            'contact_editpetugas' => 'required|numeric',
            'password_editpetugas' => 'nullable',
            'role_editpetugas' => 'required',
            'posisi_editpetugas' => 'required',
            'gaji_editpetugas' => 'required|numeric',
            'alamat_editpetugas' => 'required',
            'shift_editpetugas' => 'required|numeric',
            'foto_editpetugas' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $idKaryawan = $request->id_editpetugas;
            $idUser = $request->idUser_editpetugas;

            // 1. Update ke endpoint Karyawan
            $karyawanResponse = Http::put(config('api.base_url') . "karyawan/{$idKaryawan}", [
                'p_posisiKaryawan' => $request->posisi_editpetugas,
                'p_gajiKaryawan'   => $request->gaji_editpetugas,
                'p_alamatKaryawan' => $request->alamat_editpetugas,
                'p_idShifts'       => $request->shift_editpetugas,
            ]);

            // 2. Update ke endpoint User dengan atau tanpa gambar
            $userPayload = [
                'p_contactUsers'  => $request->contact_editpetugas,
                'p_passwordUsers' => $request->password_editpetugas,
                'p_roleUsers'     => $request->role_editpetugas,
            ];

            $userResponse = HttpHelper::putMultipart(
                config('api.base_url') . "users/{$idUser}",
                $userPayload,
                'p_gambarUser',
                $request->file('foto_editpetugas')
            );

            // Cek status response dari kedua API
            if ($karyawanResponse['status'] === 200 && $userResponse['status'] === 200) {
                return redirect('admin/datapetugas')->with('success', 'Data berhasil diperbarui!');
            } else {
                return back()->with('error', 'Gagal update ke salah satu endpoint');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id_deletepetugas' => 'required|numeric',
        ]);

        $idPetugas = $request->id_deletepetugas;

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->delete(config('api.base_url') . "karyawan/{$idPetugas}");

            if ($response['status'] === 200) {
                return redirect('admin/datapetugas')->with('success', 'Data berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}

