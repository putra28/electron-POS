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
        Schema::create('tb_pengeluaran', function (Blueprint $table) {
            $table->id('id_pengeluaran')->autoIncrement();
            $table->integer('id_kategori_pengeluaran')->nullable()->default(null);
            $table->decimal('total_pengeluaran', 15, 0)->nullable()->default(null);
            $table->text('deskripsi_pengeluaran')->nullable()->default(null);
            $table->date('tanggal')->nullable()->default(null);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
            $table->primary(['id_pengeluaran']);
            $table->index('id_kategori_pengeluaran');
            $table->foreign('id_kategori_pengeluaran', 'FK-pengeluaranToKategori')->references('id_kategori_pengeluaran')->on('tb_kategori_pengeluaran')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pengeluaran');
    }
};
