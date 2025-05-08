<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
    {

        return view('login');
    }

    public function login(Request $request)
    {
        try {
            $contact = $request->input('input_contactpetugas');
            $password = $request->input('input_passwordpetugas');

            $response = Http::post(config('api.base_url') . 'users/login', [
                'p_contactUsers' => $contact,
                'p_passwordUsers' => $password,
            ]);

            if ($response->successful()) {
                $result = $response->json();

                if (isset($result['message']) && $result['message'] === 'Login berhasil') {
                    $data = $result['data'];

                    // Simpan data user ke session
                    Session::put('tb_petugas', $data);
                    Session::put('foto_petugas', $data['gambar_user']);

                    // Clock-in
                    $absenResponse = Http::post(config('api.base_url') . 'laporanabsen/', [
                        'p_idKaryawan' => $data['data_user']['id_karyawan'],
                    ]);

                    if ($absenResponse->successful()) {
                        $absenData = $absenResponse->json();
                        // Simpan ID laporan absen untuk digunakan saat clock-out
                        Session::put('id_laporanabsen', $absenData['data']['p_idKehadiran']);
                    }

                    // Redirect sesuai role
                    if ($data['role_user'] === 'admin') {
                        return redirect('admin/dashboard');
                    } elseif ($data['role_user'] === 'kasir') {
                        return redirect('kasir/dashboard');
                    } else {
                        return redirect('/');
                    }
                } else {
                    return back()->with('error', $result['message'] ?? 'Gagal login');
                }
            } else {
                return back()->with('error', 'Tidak dapat terhubung ke server login.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan pada koneksi');
        }
    }

    public function logout(Request $request)
    {
        // Clock-out
        $idLaporanAbsen = Session::get('id_laporanabsen');
        if ($idLaporanAbsen) {
            Http::put(config('api.base_url') . "laporanabsen/{$idLaporanAbsen}");
        }

        // Hapus session
        $request->session()->forget(['tb_petugas', 'foto_petugas', 'id_laporanabsen']);
        Auth::logout();

        return redirect('/');
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

