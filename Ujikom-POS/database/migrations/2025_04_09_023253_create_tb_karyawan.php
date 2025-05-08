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
        Schema::create('tb_karyawan', function (Blueprint $table) {
            $table->increments('id_karyawan');
            $table->integer('id_user');
            $table->string('posisi_karyawan', 255)->charset('utf8mb4')->collation('utf8mb4_general_ci')->nullable();
            $table->integer('gaji_karyawan')->nullable();
            $table->integer('id_shifts')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();

            $table->primary('id_karyawan');
            $table->index('id_shifts', 'FK-karyawanToshifts');
            $table->index('id_user', 'FK-karyawanTousers');

            $table->foreign('id_shifts', 'FK-karyawanToshifts')->references('id_shifts')->on('tb_shifts')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('id_user', 'FK-karyawanTousers')->references('id_user')->on('tb_users')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_karyawan');
    }
};
