<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notifyUser;
use App\Models\BitCoin;
use App\Models\PurchaseBitCoin;
use App\Models\PurchasePerfectMoney;
use App\Confirm_sell_bitcoin;
use App\Confirm_sell_pm;

class NotifyUserController extends Controller
{
    public function Viewmsg($id) {
    	$msg = notifyUser::find($id);
    	//dd($msg);
    	 $data['page_title']="Confirm Alert";
    	 $data['msg'] = notifyUser::find($id);

    	 return view('modals.message_modal',$data);

    }


    public function delete_msg($id) {

    	$order = notifyUser::find($id);

    	$order->delete();
         return redirect()->back()->with(['message' =>'Successfully deleted!']);
    }


    public function viewBitcoin($id) {
        $data = BitCoin::find($id);
        //dd($data); 
        $data['details'] = BitCoin::find($id);
        return view('modals.bt_confirm_model', $data);
    }

    public function viewsellBitcoin($id) {
        //$data = PurchaseBitCoin::find($id);
        //dd($data);
        $data['page_title'] = "Bitcoin";
        $data['sale_details'] = PurchaseBitCoin::find($id);
        $data['conf_details'] = Confirm_sell_bitcoin::where('purchase_bitcoins_id', $id)->get();
        //dd($data);
        return view('modals.bt_confirm_sells_modal', $data);
    }
}
