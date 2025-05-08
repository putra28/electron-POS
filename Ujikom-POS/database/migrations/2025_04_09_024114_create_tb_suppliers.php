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
        Schema::create('tb_suppliers', function (Blueprint $table) {
            $table->id('id_suppliers')->autoIncrement();
            $table->string('nama_suppliers', 255)->nullable()->default(null);
            $table->string('contact_person', 255)->nullable()->default(null);
            $table->string('contact_suppliers', 255)->nullable()->default(null);
            $table->string('email_suppliers', 255)->nullable()->default(null);
            $table->text('alamat_suppliers')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
            $table->primary('id_suppliers', 'primary')->using('BTREE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_suppliers');
    }
};
