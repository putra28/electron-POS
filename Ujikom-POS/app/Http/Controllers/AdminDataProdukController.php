<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\ProdukHelper;
use App\Helpers\HttpHelper;

class AdminDataProdukController extends Controller
{
    public function index()
    {
        try {
            $produkResponse = Http::get(config('api.base_url') . 'produk/');
            $kategoriResponse = Http::get(config('api.base_url') . 'kategori/notfiltered/');

            if ($produkResponse['status'] === 200 && $kategoriResponse->successful()) {
                return view('admin.dataproduk', [
                    'produk' => $produkResponse['data'],
                    'kategori' => $kategoriResponse['data']
                ]);
            }
        } catch (\Exception $e) {
            return view('admin.dataproduk', [
                'produk' => [],
                'kategori' => [],
                'error' => 'Gagal mengambil data produk'
            ]);
        }
    }

    public function create()
    {
        // Kosongkan dulu jika tidak dipakai
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_addproduk'        => 'required',
            'kategori_addproduk'    => 'required',
            'subkategori_addproduk' => 'required',
            'hargaModal_addproduk'  => 'required|numeric',
            'hargaJual_addproduk'   => 'required|numeric',
            'diskon_addproduk'      => 'required|numeric',
            'stok_addproduk'        => 'required|numeric',
            'stokMin_addproduk'     => 'required|numeric',
            'status_addproduk'      => 'required',
            'deskripsi_addproduk'   => 'required',
            'foto_addproduk'        => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $sku = ProdukHelper::generateSKU(
            $request->kategori_addproduk,
            $request->subkategori_addproduk,
            $request->nama_addproduk
        );

        $barcode = ProdukHelper::generateBarcode($request->subkategori_addproduk, $sku);
        $image = $request->file('foto_addproduk');

        $payload = [
            'p_idKategori'         => $request->subkategori_addproduk,
            'p_namaProduk'         => $request->nama_addproduk,
            'p_skuProduk'          => $sku,
            'p_barcodeProduk'      => $barcode,
            'p_deskripsiProduk'    => $request->deskripsi_addproduk,
            'p_hargaProduk'        => $request->hargaJual_addproduk,
            'p_modalProduk'        => $request->hargaModal_addproduk,
            'p_diskonProduk'       => $request->diskon_addproduk,
            'p_stokProduk'         => $request->stok_addproduk,
            'p_stokMinimumProduk'  => $request->stokMin_addproduk,
            'p_statusProduk'       => $request->status_addproduk,
        ];

        $response = Http::attach(
            'p_gambarProduk',
            fopen($image->getPathname(), 'r'),
            $image->getClientOriginalName()
        )->post(config('api.base_url') . 'produk', $payload);

        if ($response['status'] === 200) {
            return redirect('admin/dataproduk')->with('success', 'Produk berhasil ditambahkan.');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan produk: ' . $response->body());
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_editproduk'         => 'required|numeric',
            'hargaModal_editproduk' => 'required|numeric',
            'hargaJual_editproduk'  => 'required|numeric',
            'diskon_editproduk'     => 'required|numeric',
            'stok_editproduk'       => 'required|numeric',
            'stokMin_editproduk'    => 'required|numeric',
            'status_editproduk'     => 'required',
            'deskripsi_editproduk'  => 'required',
            'foto_editproduk'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $idProduk = $request->id_editproduk;

        $payload = [
            'p_modalProduk'        => $request->hargaModal_editproduk,
            'p_hargaProduk'        => $request->hargaJual_editproduk,
            'p_diskonProduk'       => $request->diskon_editproduk,
            'p_stokProduk'         => $request->stok_editproduk,
            'p_stokMinimumProduk'  => $request->stokMin_editproduk,
            'p_statusProduk'       => $request->status_editproduk,
            'p_deskripsiProduk'    => $request->deskripsi_editproduk,
        ];

        $url = config('api.base_url') . "produk/{$idProduk}";

        $response = HttpHelper::putMultipart(
            $url,
            $payload,
            'p_gambarProduk',
            $request->file('foto_editproduk')
        );

        if ($response['status'] === 200) {
            return redirect('admin/dataproduk')->with('success', 'Produk berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui produk: ' . $response->json()['message']);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id_deleteproduk' => 'required|numeric',
        ]);

        $idProduk = $request->id_deleteproduk;

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->delete(config('api.base_url') . "produk/{$idProduk}");

            if ($response['status'] === 200) {
                return redirect('admin/dataproduk')->with('success', 'Produk berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'Gagal menghapus produk: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage());
        }
    }
}

