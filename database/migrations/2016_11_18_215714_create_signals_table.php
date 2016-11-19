<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pair_id')->unsigned();
            $table->foreign('pair_id')->references('id')->on('pairs')->onDelete('cascade');
            $table->string('cs_signal', 7);
            $table->string('p_m5', 7);
            $table->string('p_m15', 7);
            $table->string('p_m30', 7);
            $table->string('p_h1', 7);
            $table->string('TD_m5', 7);
            $table->string('TD_m15', 7);
            $table->string('TD_h1', 7);
            $table->string('TD_LTS', 7);
            $table->string('TD_HTS', 7);
            $table->string('TD_TS', 7);
            $table->string('EVO_5', 7);
            $table->string('EVO_15', 7);
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
        Schema::dropIfExists('signals');
    }
}
