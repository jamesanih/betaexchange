<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Confirm_buy_bitcoins extends Model
{
    protected $fillable = ['user_id','date_sent', 'details_no', 'amount_paid', 'depositor_name', 'receipt_dir'];

}
