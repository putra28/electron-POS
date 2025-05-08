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
        Schema::create('tb_kategori_pengeluaran', function (Blueprint $table) {
            $table->id('id_kategori_pengeluaran')->autoIncrement();
            $table->string('nama_kategori_pengeluaran', 255)->nullable()->default(null);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();

            $table->primary(['id_kategori_pengeluaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_kategori_pengeluaran');
    }
};
