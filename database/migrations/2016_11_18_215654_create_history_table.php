<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pair_id')->unsigned();
            $table->foreign('pair_id')->references('id')->on('pairs')->onDelete('cascade');
            $table->string('order_type', 4);
            $table->text('bid_price');
            $table->text('difference')->nullable();
            $table->string('m5', 4)->default('rate');
            $table->string('m15', 4)->default('rate');
            $table->string('h1', 4)->default('rate');
            $table->string('rating', 10);
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
        Schema::dropIfExists('history');
    }
}
