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
            $table->foreignUuid('id_perhitungan')->references('id')->on('perhitungan_oee');
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