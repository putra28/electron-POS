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
        Schema::create('tb_izin_karyawan', function (Blueprint $table) {
            $table->increments('id_izin');
            $table->integer('id_karyawan')->nullable()->default(null);
            $table->integer('id_jenis_izin')->nullable()->default(null);
            $table->date('start_date')->nullable()->default(null);
            $table->date('end_date')->nullable()->default(null);
            $table->enum('status', ['Approved', 'Pending', 'Rejected'])->charset('utf8mb4')->collation('utf8mb4_general_ci')->nullable()->default(null);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();

            $table->index('id_karyawan', 'FK-izinTokaryawan');
            $table->index('id_jenis_izin', 'FK-izinToJenisIzin');

            $table->foreign('id_karyawan', 'FK-izinTokaryawan')->references('id_karyawan')->on('tb_karyawan')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('id_jenis_izin', 'FK-izinToJenisIzin')->references('id_kategori_izin')->on('tb_kategori_izin')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_izin_karyawan');
    }
};
