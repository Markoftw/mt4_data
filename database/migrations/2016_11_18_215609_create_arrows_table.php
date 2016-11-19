<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pair_id')->unsigned();
            $table->foreign('pair_id')->references('id')->on('pairs')->onDelete('cascade');
            $table->string('m5_color', 5);
            $table->string('m15_color', 5);
            $table->string('h1_color', 5);
            $table->string('lts_color', 5);
            $table->string('hts_color', 5);
            $table->string('ts_color', 5);
            $table->string('ts_direction', 10);
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
        Schema::dropIfExists('arrows');
    }
}
