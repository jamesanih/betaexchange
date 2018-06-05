<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBitcoinsIdToConfirmBuyBitcoins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('confirm_buy_bitcoins', function (Blueprint $table) {
            $table->integer('bitcoins_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('confirm_buy_bitcoins', function (Blueprint $table) {
            $table->dropColumn('bitcoins_id');
        });
    }
}
