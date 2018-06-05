<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfirmSellPmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirm_sell_pms', function (Blueprint $table) {
           $table->increments('id');
            $table->integer('user_id')->unique();
            $table->string('date_sent');
            $table->string('batch_number');
            $table->string('amount_sent');
            $table->string('wallet_id');
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
        Schema::dropIfExists('confirm_sell_pms');
    }
}
