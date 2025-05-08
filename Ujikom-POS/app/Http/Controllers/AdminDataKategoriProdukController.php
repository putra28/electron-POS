<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminDataKategoriProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $kategoriResponse = Http::get(config('api.base_url') . 'kategori/');

            if ($kategoriResponse->successful()) {
                return view('admin.datakategori', [
                    'kategori' => $kategoriResponse['data']
                ]);
            }
        } catch (\Exception $e) {
            return view('admin.datakategori', [
                'kategori' => [],
                'error' => 'Gagal mengambil data kategori'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Step 1: Add Kategori
            $kategoriResponse = Http::post(config('api.base_url') . 'kategori/', [
                'p_namaKategori' => $request->namaKategori_addKategoriProduk
            ]);

            if (!$kategoriResponse->successful()) {
                return back()->with('error', 'Gagal menambahkan kategori.');
            }

            // Ambil ID dari response
            $kategoriId = $kategoriResponse->json('data.p_idKategori') ?? null;

            if (!$kategoriId) {
                return back()->with('error', 'ID kategori tidak ditemukan setelah penambahan.');
            }

            // Step 2: Tambah semua subkategori
            foreach ($request->subKategori_addKategoriProduk as $subKategori) {
                $subResponse = Http::post(config('api.base_url') . "kategori/{$kategoriId}/subkategori/", [
                    'p_namaSubKategori' => $subKategori
                ]);

                if (!$subResponse->successful()) {
                    return back()->with('error', "Gagal menambahkan subkategori: {$subKategori}.");
                }
            }

            // Jika semua sukses
            return back()->with('success', 'Kategori dan subkategori berhasil ditambahkan.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menambahkan kategori dan subkategori: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $idKategori = $request->input('idKategori_editKategoriProduk');
        $namaKategori = $request->input('namaKategori_editKategoriProduk');
        $idSubKategoriList = $request->input('edit_idsubKategoriProduk', []);
        $namaSubKategoriList = $request->input('edit_subKategoriProduk', []);
        $subKategoriBaruList = $request->input('subKategori_editKategoriProduk', []); // Subkategori baru yang ditambahkan

        try {
            // 1. Update kategori
            $kategoriResponse = Http::put(config('api.base_url') . "kategori/$idKategori", [
                'p_namaKategori' => $namaKategori
            ]);

            if (!$kategoriResponse->ok()) {
                return back()->with('error', 'Gagal update kategori');
            }

            // 2. Update semua subkategori yang sudah ada
            foreach ($idSubKategoriList as $i => $idSubKategori) {
                $namaSubKategori = $namaSubKategoriList[$i] ?? null;

                if (!$namaSubKategori) continue; // skip kalau tidak ada nama

                $subkategoriResponse = Http::put(config('api.base_url') . "kategori/$idKategori/subkategori/$idSubKategori", [
                    'p_namaSubKategori' => $namaSubKategori
                ]);

                if (!$subkategoriResponse->ok()) {
                    return back()->with('error', 'Gagal update subkategori dengan ID: ' . $idSubKategori);
                }
            }

            // 3. Menambah subkategori baru
            foreach ($subKategoriBaruList as $namaSubKategori) {
                if ($namaSubKategori) {
                    $subkategoriResponse = Http::post(config('api.base_url') . "kategori/$idKategori/subkategori", [
                        'p_namaSubKategori' => $namaSubKategori
                    ]);

                    if (!$subkategoriResponse->ok()) {
                        return back()->with('error', 'Gagal menambah subkategori: ' . $namaSubKategori);
                    }
                }
            }

            return back()->with('success', 'Berhasil update kategori dan subkategori.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id_deleteKategori' => 'required|numeric',
        ]);

        $idKategori = $request->id_deleteKategori;

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->delete(config('api.base_url') . "kategori/{$idKategori}");

            if ($response['status'] === 200) {
                return redirect('admin/datakategori')->with('success', 'Kategori berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'Gagal menghapus kategori: ' . $response->json()['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kategori: ' . $e->getMessage());
        }
    }
}

