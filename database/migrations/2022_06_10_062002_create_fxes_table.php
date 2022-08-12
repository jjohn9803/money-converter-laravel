<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fxes', function (Blueprint $table) {
            $table->id();
            /* $table->unsignedBigInteger('base_currency_id')->default(1);
            $table->foreign('base_currency_id')->references('id')->on('currencies')->onDelete('cascade'); */
            $table->unsignedBigInteger('result_currency_id');
            $table->foreign('result_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->float('fx_rate',100,6);
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
        Schema::dropIfExists('fxes');
    }
}
