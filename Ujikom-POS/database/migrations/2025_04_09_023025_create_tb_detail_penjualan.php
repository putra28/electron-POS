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
        Schema::create('tb_detail_penjualan', function (Blueprint $table) {
            $table->id('id_detail_penjualan');
            $table->integer('id_penjualan')->nullable()->index();
            $table->integer('id_produk')->nullable()->index();
            $table->integer('kuantitas')->nullable();
            $table->decimal('harga', 15, 0)->nullable();
            $table->decimal('subtotal', 15, 0)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();

            $table->foreign('id_penjualan', 'FK-detailToPenjualan')
                ->references('id_penjualan')->on('tb_penjualan')
                ->onDelete('cascade')->onUpdate('restrict');

            $table->foreign('id_produk', 'FK-detailToProduk')
                ->references('id_produk')->on('tb_produk')
                ->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_detail_penjualan');
    }
};
