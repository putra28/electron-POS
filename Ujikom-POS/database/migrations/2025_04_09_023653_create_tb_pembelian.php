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
        Schema::create('tb_pembelian', function (Blueprint $table) {
            $table->id('id_pembelian')->autoIncrement();
            $table->integer('id_suppliers')->nullable()->constrained('tb_suppliers')->onDelete('restrict')->onUpdate('restrict');
            $table->decimal('total_harga', 15, 0)->nullable();
            $table->enum('status_pembelian', ['Success', 'Pending', 'Canceled'])->charset('utf8mb4')->collation('utf8mb4_general_ci')->nullable()->default(null);
            $table->date('tanggal_pembelian')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
            $table->primary('id_pembelian', 'primary')->using('BTREE');
            $table->index('id_suppliers', 'FK-pembelianToSuppliers')->using('BTREE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pembelian');
    }
};
