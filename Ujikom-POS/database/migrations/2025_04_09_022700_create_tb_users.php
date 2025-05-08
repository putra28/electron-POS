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
        Schema::create('tb_users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_user', 255)->nullable();
            $table->string('password_user', 255)->nullable();
            $table->string('contact_user', 255)->nullable();
            $table->enum('role_user', ['admin', 'kasir'])->nullable();
            $table->enum('status_user', ['aktif', 'non-aktif'])->nullable();
            $table->text('gambar_user')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_users');
    }
};
