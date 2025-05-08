<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminDataSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $supplierResponse = Http::get(config('api.base_url') . 'suppliers/');

            if ($supplierResponse['status'] === 200) {
                return view('admin.datasupplier', [
                    'suppliers' => $supplierResponse['data']
                ]);
            }
        } catch (\Exception $e) {
            return view('admin.datasupplier', [
                'suppliers' => [],
                'error' => 'Gagal mengambil data supplier'
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
                'nama_addsupplier'        => 'required',
                'contactPerson_addsupplier'    => 'required|numeric',
                'contactSuppliers_addsupplier' => 'required|numeric',
                'email_addsupplier'  => 'required',
                'alamat_addsupplier' => 'required',
            ]);

            $data = [
                'p_namaSuppliers'         => $request->nama_addsupplier,
                'p_contactPerson'         => $request->contactPerson_addsupplier,
                'p_contactSuppliers'         => $request->contactSuppliers_addsupplier,
                'p_emailSuppliers'         => $request->email_addsupplier,
                'p_alamatSuppliers'         => $request->alamat_addsupplier,
            ];
            $response = Http::post(config('api.base_url') . 'suppliers/', $data);

            if ($response['status'] === 200) {
                return redirect('admin/datasupplier')->with('success', 'Supplier berhasil ditambahkan.');
            }

            return redirect()->back()->with('error', 'Gagal menambahkan supplier: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan supplier: ' . $e->getMessage());
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
        $request->validate([
            'id_editSupplier'        => 'required|numeric',
            'nama_editSupplier'        => 'required',
            'contactPerson_editSupplier'    => 'required|numeric',
            'contactSuppliers_editSupplier' => 'required|numeric',
            'email_editSupplier'  => 'required',
            'alamat_editSupplier' => 'required',
        ]);

        $id = $request->id_editSupplier;
        $url = config('api.base_url') . "suppliers/{$id}";

        $data = [
            'p_namaSuppliers'         => $request->nama_editSupplier,
            'p_contactPerson'         => $request->contactPerson_editSupplier,
            'p_contactSuppliers'         => $request->contactSuppliers_editSupplier,
            'p_emailSuppliers'         => $request->email_editSupplier,
            'p_alamatSuppliers'         => $request->alamat_editSupplier,
        ];

        $response = Http::put($url, $data);

        if ($response['status'] === 200) {
            return redirect('admin/datasupplier')->with('success', 'Supplier berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui supplier: ' . $response->body());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id_deletesupplier' => 'required|numeric',
        ]);

        $idSupplier = $request->id_deletesupplier;

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->delete(config('api.base_url') . "suppliers/{$idSupplier}");

            if ($response['status'] === 200) {
                return redirect('admin/datasupplier')->with('success', 'Supplier berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'Gagal menghapus supplier: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus supplier: ' . $e->getMessage());
        }
    }
}

