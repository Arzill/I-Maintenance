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
        Schema::create('detail_maintenances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_maintenance');
            $table->string('nama_mesin');
            $table->time('shift_start')->nullable();
            $table->time('shift_end')->nullable();
            $table->integer('planned_downtime')->nullable();
            $table->integer('unplanned_downtime')->nullable();
            $table->integer('total_parts_produced')->nullable();
            $table->integer('ideal_cycle_time')->nullable();
            $table->integer('total_scrap')->nullable();
            $table->float('performance')->nullable();
            $table->float('quality')->nullable();
            $table->float('avaibility')->nullable();
            $table->string('status_oee')->nullable();
            $table->integer('peluang_kegagalan')->nullable();
            $table->integer('konsekuensi_kegagalan')->nullable();
            $table->decimal('biaya_perbaikan', 12, 2)->nullable();
            $table->decimal('biaya_kerugian_produksi', 12, 2)->nullable();
            $table->decimal('biaya_inisiasi', 12, 2)->nullable();
            $table->decimal('biaya_operasional_tahunan', 12, 2)->nullable();
            $table->decimal('biaya_pemeliharaan_tahunan', 12, 2)->nullable();
            $table->decimal('biaya_pembongkaran', 12, 2)->nullable();
            $table->float('estimasi_tahunan')->nullable();
            $table->float('result_oee')->nullable();
            $table->float('result_rmb')->nullable();
            $table->decimal('result_lcc')->nullable();
            $table->timestamps();

            $table->foreign('id_maintenance')->references('id')->on('maintenances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oees');
    }
};
