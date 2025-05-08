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
        Schema::create('tb_subkategori', function (Blueprint $table) {
            $table->increments('id_subkategori');
            $table->integer('id_kategori')->nullable()->default(null);
            $table->string('nama_subkategori', 255)->charset('utf8mb4')->collation('utf8mb4_general_ci')->nullable()->default(null);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->primary('id_subkategori')->using('BTREE');
            $table->index('id_kategori', 'FK-SubtoKategori')->using('BTREE');
            $table->foreign('id_kategori', 'FK-SubtoKategori')
                ->references('id_kategori')->on('tb_kategori')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_subkategori');
    }
};
