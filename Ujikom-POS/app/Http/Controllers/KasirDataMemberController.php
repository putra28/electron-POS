<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class KasirDataMemberController extends Controller
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

            return view('kasir.datamember', [
                'member' => $get_member
            ]);
        } catch (\Exception $e) {
            return view('kasir.datamember', [
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
                return redirect('kasir/dashboard')->with('success', 'Customer berhasil ditambahkan.');
            } else {
                return redirect('kasir/dashboard')->with('error', 'Gagal menambahkan customer.');
            }
        } catch (\Exception $e) {
            return redirect('kasir/dashboard')->with('error', 'Terjadi kesalahan saat menambahkan customer');
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

