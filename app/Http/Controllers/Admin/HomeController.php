<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Price;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["price"]=Price::first();
        return view('admin.index',$data);
    }



      
    public function update_rates(Request  $request)
    {

    $price = Price::find(1);
     if($price)
     {
      
     $price->bitcoin = $request['bitcoin'];
     $price->perfect_money = $request['perfect_money'];
     $price->bitcoin_sell = $request['bitcoin_sell'];
     $price->perfect_money_sell = $request['perfect_money_sell'];
     $price->save(); 
    }
     return redirect("/administrator");

  }

}
