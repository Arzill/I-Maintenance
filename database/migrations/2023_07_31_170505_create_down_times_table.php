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
        Schema::create('down_times', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_perhitungan')->references('id')->on('perhitungan_oee');
            $table->string('jenis_downtime');
            $table->time('jam_mulai_downtime');
            $table->time('jam_selesai_downtime');
            $table->integer('jumlah_downtime');
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
        Schema::dropIfExists('down_times');
    }
};
