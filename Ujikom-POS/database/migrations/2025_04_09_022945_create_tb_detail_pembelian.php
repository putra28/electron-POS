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
        Schema::create('tb_detail_pembelian', function (Blueprint $table) {
            $table->id('id_detail_pembelian')->autoIncrement();
            $table->integer('id_pembelian')->nullable()->constrained('tb_pembelian')->onDelete('cascade')->onUpdate('restrict');
            $table->integer('id_produk')->nullable()->constrained('tb_produk')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('kuantitas')->nullable();
            $table->decimal('harga', 15, 0)->nullable();
            $table->decimal('subtotal', 15, 0)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->primary(['id_detail_pembelian']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_detail_pembelian');
    }
};
