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
        Schema::create('perhitungan_oee', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_mesin')->references('id')->on('maintenances');
            $table->time('waktu_mulai_produksi');
            $table->time('waktu_selesai_produksi');
            $table->integer('waktu_total_produksi')->default(0);
            $table->integer('down_time_terencana')->default(0);
            $table->integer('total_produksi')->default(0);
            $table->integer('tingkat_produksi_ideal')->default(0);
            $table->integer('produksi_cacat')->default(0);
            $table->integer('produksi_baik')->default(0);
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
        Schema::dropIfExists('perhitungan_o_e_e_s');
    }
};
