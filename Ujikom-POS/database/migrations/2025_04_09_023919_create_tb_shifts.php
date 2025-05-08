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
        Schema::create('tb_shifts', function (Blueprint $table) {
            $table->increments('id_shifts');
            $table->string('nama_shifts', 255)->charset('utf8mb4')->collation('utf8mb4_general_ci')->nullable()->default(null);
            $table->time('start_time')->nullable()->default(null);
            $table->time('end_time')->nullable()->default(null);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_shifts');
    }
};
