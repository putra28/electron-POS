<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminDataMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Ambil data customer dari API eksternal
            $response = Http::get(config('api.base_url') . 'customer/');

            if ($response['status'] === 200) {
                $get_member = $response['data']; // ambil array data dari JSON
            } else {
                $get_member = []; // fallback kosong kalau gagal
            }

            return view('admin.datamember', [
                'member' => $get_member
            ]);
        } catch (\Exception $e) {
            return view('admin.datamember', [
                'member' => [],
                'error' => 'Gagal mengambil data member'
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
            $data = [
                'p_namaCustomers'     => $request->input('nama_addmember'),
                'p_genderCustomers'   => $request->input('gender_addmember'),
                'p_tglLahirCustomers' => $request->input('tgllahir_addmember'),
                'p_telpCustomers'     => $request->input('telp_addmember'),
                'p_emailCustomers'    => $request->input('email_addmember'),
                'p_alamatCustomers'   => $request->input('alamat_addmember'),
            ];

            $response = Http::post(config('api.base_url') . 'customer/', $data);

            if ($response['status'] === 200) {
                return redirect('admin/datamember')->with('success', 'Customer berhasil ditambahkan.');
            } else {
                return redirect('admin/datamember')->with('error', 'Gagal menambahkan customer.');
            }
        } catch (\Exception $e) {
            return redirect('admin/datamember')->with('error', 'Terjadi kesalahan saat menambahkan customer');
        }
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
    public function update(Request $request)
    {
        try {
            $idCustomers = $request->input('id_editmember');

            $url = config('api.base_url') . "customer/{$idCustomers}";
            $data = [
                'p_telpCustomers'     => $request->input('telp_editmember'),
                'p_emailCustomers'   => $request->input('email_editmember'),
                'p_alamatCustomers' => $request->input('alamat_editmember'),
                'p_statusCustomers'     => $request->input('status_editmember'),
            ];
            // dd($data, $url);

            $response = Http::put($url, $data);

            if ($response['status'] === 200) {
                return redirect('admin/datamember')->with('success', $response['message']);
            } else {
                return redirect('admin/datamember')->with('error', 'Gagal mengubah customer.');
            }
        } catch (\Exception $e) {
            return redirect('admin/datamember')->with('error', 'Terjadi kesalahan saat mengubah customer');
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
            ])->delete(config('api.base_url') . "customer/{$idCustomers}");

            if ($response['status'] === 200) {
                return redirect('admin/datamember')->with('success', 'Customer berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'Gagal menghapus customer: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus customer: ' . $e->getMessage());
        }
    }
}
