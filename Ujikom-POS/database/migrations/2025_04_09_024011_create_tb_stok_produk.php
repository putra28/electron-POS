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
        Schema::create('tb_stok_produk', function (Blueprint $table) {
            $table->increments('id_laporan_stok');
            $table->integer('id_produk')->nullable()->default(null);
            $table->string('perubahan_stok', 255)->charset('utf8mb4')->collation('utf8mb4_general_ci')->nullable()->default(null);
            $table->string('alasan_perubahan', 255)->charset('utf8mb4')->collation('utf8mb4_general_ci')->nullable()->default(null);
            $table->string('nama_karyawan', 255)->charset('utf8mb4')->collation('utf8mb4_general_ci')->nullable()->default(null);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

            $table->primary('id_laporan_stok')->using('BTREE');
            $table->index('id_produk', 'FK-stokToProduk')->using('BTREE');
            $table->index('nama_karyawan', 'FK-stokToUsers')->using('BTREE');

            $table->foreign('id_produk', 'FK-stokToProduk')
                ->references('id_produk')->on('tb_produk')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_stok_produk');
    }
};
