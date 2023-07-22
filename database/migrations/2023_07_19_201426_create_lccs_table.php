<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lccs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_maintenance')->references('id')->on('maintenances');
            // $table->string('nama_mesin');
            $table->decimal('biaya_inisiasi', 12, 2)->default(0);
            $table->decimal('biaya_operasional_tahunan', 12, 2)->default(0);
            $table->decimal('biaya_pemeliharaan_tahunan', 12, 2)->default(0);
            $table->decimal('biaya_pembongkaran', 12, 2)->default(0);
            $table->float('estimasi_tahunan')->default(0);
            $table->decimal('result_lcc', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lccs');
    }
};
