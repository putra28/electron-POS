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
        Schema::create('tb_kehadiran', function (Blueprint $table) {
            $table->id('id_kehadiran');
            $table->integer('id_karyawan')->nullable()->default(null);
            $table->date('tanggal_kehadiran')->nullable()->default(null);
            $table->time('clock_in')->nullable()->default(null);
            $table->time('clock_out')->nullable()->default(null);
            $table->string('total_jam_kerja', 255)->nullable()->default(null);
            $table->string('total_overtime', 255)->nullable()->default(null);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();

            $table->primary('id_kehadiran');

            $table->index('id_karyawan', 'FK-kehadiranTokaryawan');

            $table->foreign('id_karyawan', 'FK-kehadiranTokaryawan')
                ->references('id_karyawan')->on('tb_karyawan')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_kehadiran');
    }
};
