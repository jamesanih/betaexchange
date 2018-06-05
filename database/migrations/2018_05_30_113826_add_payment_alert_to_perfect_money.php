<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentAlertToPerfectMoney extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perfect_money', function (Blueprint $table) {
            $table->string('payment_alert')->default('not sent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('perfect_money', function (Blueprint $table) {
            $table->dropColumn('payment_alert');
        });
    }
}
