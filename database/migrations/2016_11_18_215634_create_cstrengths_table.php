<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCstrengthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cstrengths', function (Blueprint $table) {
            $table->increments('id');
            $table->text('usd_now');
            $table->text('usd_then');
            $table->text('eur_now');
            $table->text('eur_then');
            $table->text('gbp_now');
            $table->text('gbp_then');
            $table->text('chf_now');
            $table->text('chf_then');
            $table->text('jpy_now');
            $table->text('jpy_then');
            $table->text('aud_now');
            $table->text('aud_then');
            $table->text('cad_now');
            $table->text('cad_then');
            $table->text('nzd_now');
            $table->text('nzd_then');
            $table->text('mkt');
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
        Schema::dropIfExists('cstrengths');
    }
}
