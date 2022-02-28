<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_amounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('clientid')->index('clientid');
            $table->bigInteger('total_amount');
            $table->bigInteger('fee_amount');
            $table->bigInteger('merchant_amount');
            $table->date('date')->index('date');
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
        Schema::dropIfExists('available_amounts');
    }
}
