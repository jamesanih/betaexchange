<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPurchasePerfectMoneyIdToConfirmSellPms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('confirm_sell_pms', function (Blueprint $table) {
            $table->integer('purchase_perfect_money_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('confirm_sell_pms', function (Blueprint $table) {
            $table->dropColumn('purchase_perfect_money_id');
        });
    }
}
