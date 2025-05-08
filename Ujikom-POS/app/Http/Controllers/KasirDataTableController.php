<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\ProdukHelper;
use App\Helpers\HttpHelper;

class KasirDataTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $produkResponse = Http::get(config('api.base_url') . 'produk/');
            $kategoriResponse = Http::get(config('api.base_url') . 'kategori/');

            if ($produkResponse['status'] === 200 && $kategoriResponse->successful()) {
                return view('kasir.dataproduk', [
                    'produk' => $produkResponse['data'],
                    'kategori' => $kategoriResponse['data']
                ]);
            }
        } catch (\Exception $e) {
            return view('kasir.dataproduk', [
                'produk' => [],
                'kategori' => [],
                'error' => 'Gagal mengambil data produk'
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

