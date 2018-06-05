<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSalesAlertToPurchasePerfectMoney extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_perfect_money', function (Blueprint $table) {
            $table->string('sales_alert')->default('not sent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_perfect_money', function (Blueprint $table) {
            $table->dropColumn('sales_alert');
        });
    }
}
