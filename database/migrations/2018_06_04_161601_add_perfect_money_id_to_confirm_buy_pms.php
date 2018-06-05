<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPerfectMoneyIdToConfirmBuyPms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('confirm_buy_pms', function (Blueprint $table) {
            $table->integer('perfect_money_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('confirm_buy_pms', function (Blueprint $table) {
            $table->dropColumn('perfect_money_id');
        });
    }
}
