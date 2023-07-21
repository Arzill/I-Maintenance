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
        Schema::create('rbms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_maintenance')->references('id')->on('maintenances');
            $table->string('jangka_waktu');
            $table->integer('severity')->default(0);
            $table->integer('occurrence')->default(0);
            $table->float('result_rbm')->default(0);
            $table->string('risk');
            $table->string('rekomendasi');
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
        Schema::dropIfExists('rbms');
    }
};