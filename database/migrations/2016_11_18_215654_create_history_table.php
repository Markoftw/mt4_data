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
            $table->string('m5', 6)->default('ratem5');
            $table->string('m15', 7)->default('ratem15');
            $table->string('h1', 6)->default('rateh1');
            $table->string('rating', 10)->default('rate');
            $table->string('order_placed', 3)->default('No');
            $table->string('order_completed', 3)->default('No');
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
