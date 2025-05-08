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
        Schema::create('tb_kategori_izin', function (Blueprint $table) {
            $table->increments('id_kategori_izin');
            $table->string('nama_kategori_izin', 255)->charset('utf8mb4')->collation('utf8mb4_general_ci')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
            $table->primary('id_kategori_izin', 'primary')->using('BTREE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_kategori_izin');
    }
};
