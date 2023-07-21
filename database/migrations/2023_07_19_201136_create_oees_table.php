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
        Schema::create('oees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_maintenance')->references('id')->on('maintenances');
            // $table->string('nama_mesin');
            $table->time('shift_start');
            $table->time('shift_end');
            $table->integer('planned_downtime')->default(0);
            $table->integer('unplanned_downtime')->default(0);
            $table->integer('total_parts_produced')->default(0);
            $table->integer('ideal_run_rate')->default(0);
            $table->integer('total_scrap')->default(0);
            $table->float('performance');
            $table->float('quality');
            $table->float('avaibility');
            $table->string('status_oee');
            $table->float('result_oee');
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
        Schema::dropIfExists('oees');
    }
};
