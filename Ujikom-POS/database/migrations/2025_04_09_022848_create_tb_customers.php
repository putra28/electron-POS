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
        Schema::create('tb_customers', function (Blueprint $table) {
            $table->id('id_customers')->autoIncrement();
            $table->string('nama_customers', 255)->nullable();
            $table->string('telp_customers', 255)->nullable();
            $table->string('email_customers', 255)->nullable();
            $table->text('alamat_customers')->nullable();
            $table->enum('status_customers', ['aktif', 'non-aktif'])->nullable()->default('aktif');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_customers');
    }
};
