<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->integer('id_kategori')->nullable()->default(null);
            $table->string('nama_produk', 255)->nullable()->default(null);
            $table->string('sku_produk', 255)->nullable()->default(null);
            $table->string('barcode_produk', 255)->nullable()->default(null);
            $table->string('deskripsi_produk', 255)->nullable()->default(null);
            $table->decimal('harga_produk', 15, 0)->nullable()->default(null);
            $table->decimal('modal_produk', 15, 0)->nullable()->default(null);
            $table->integer('stok_produk')->nullable()->default(null);
            $table->integer('stok_minimum_produk')->nullable()->default(null);
            $table->text('gambar_produk')->nullable()->default(null);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->primary('id_produk');
            $table->index('id_kategori', 'FK-produkToSubKategori');

            $table->foreign('id_kategori', 'FK-produkToSubKategori')
                ->references('id_subkategori')->on('tb_subkategori')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_produk');
    }
};
