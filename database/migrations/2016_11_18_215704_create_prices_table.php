<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pair_id')->unsigned();
            $table->foreign('pair_id')->references('id')->on('pairs')->onDelete('cascade');
            $table->text('bid_price');
            $table->text('period_m5');
            $table->text('period_m15');
            $table->text('period_m30');
            $table->text('period_h1');
            $table->text('m5_up');
            $table->text('m15_up');
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
        Schema::dropIfExists('prices');
    }
}
