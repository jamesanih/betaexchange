<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Helpers\Utility;
use App\Models\PurchasePerfectMoney;
use App\Models\PurchaseBitCoin;


class SellCurrencyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

   /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $data['title']='Bitcoins';
    $data['bitcoins']=PurchaseBitCoin::latest('id')->get(); 
    $data['perfects']=PurchasePerfectMoney::latest('id')->get(); 
    return view('admin.sell.index',$data);
  }




  
}

?>