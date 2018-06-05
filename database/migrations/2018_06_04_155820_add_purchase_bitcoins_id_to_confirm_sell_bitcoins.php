<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPurchaseBitcoinsIdToConfirmSellBitcoins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('confirm_sell_bitcoins', function (Blueprint $table) {
            $table->integer('purchase_bitcoins_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('confirm_sell_bitcoins', function (Blueprint $table) {
            $table->dropColumn('purchase_bitcoins_id');
        });
    }
}
