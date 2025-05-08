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
        Schema::create('tb_penjualan', function (Blueprint $table) {
            $table->id('id_penjualan')->autoIncrement();
            $table->integer('id_customers')->nullable()->default(null)->constrained('tb_customers')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('id_karyawan')->nullable()->default(null)->constrained('tb_karyawan')->onDelete('restrict')->onUpdate('restrict');
            $table->decimal('total_harga', 15, 0)->nullable()->default(null);
            $table->enum('status_pembayaran', ['Success', 'Pending', 'Canceled'])->charset('utf8mb4')->collation('utf8mb4_general_ci')->nullable()->default(null);
            $table->date('tanggal_penjualan')->nullable()->default(null);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
            $table->primary('id_penjualan', 'primary')->using('BTREE');
            $table->index('id_customers', 'FK-penjualanToCustomers')->using('BTREE');
            $table->index('id_karyawan', 'FK-penjualanToKaryawan')->using('BTREE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_penjualan');
    }
};
