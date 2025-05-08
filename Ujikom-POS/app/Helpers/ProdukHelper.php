<?php

namespace App\Helpers;

class ProdukHelper
{
    public static function generateSKU($idKategori, $idSubKategori, $namaProduk)
    {
        $namaTanpaVokal = preg_replace('/[aeiouAEIOU\s]/', '', $namaProduk);
        $kategoriKode = str_pad($idKategori, 3, '0', STR_PAD_LEFT);
        $subKategoriKode = str_pad($idSubKategori, 3, '0', STR_PAD_LEFT);
        $sku = $kategoriKode . $subKategoriKode . strtoupper($namaTanpaVokal);
        return $sku;
    }

    public static function generateBarcode($idKategori, $sku)
    {
        $kategoriKode = 'KAT';
        $randomAngka = mt_rand(100, 999);
        return $kategoriKode . $sku . $randomAngka;
    }
}
