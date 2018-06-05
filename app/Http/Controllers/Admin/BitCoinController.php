<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Helpers\Utility;
use App\Models\BitCoin;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Mail;

class BitCoinController extends Controller
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
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $data['title']='Bitcoins';
    $data['users']=User::where('isAdmin','=',false)
    ->with("account_detail","next_kin")->get();
    $data['bitcoins']=BitCoin::latest('id')->get(); 
   
    return view('admin.bitcoins.index',$data);
  }



    private function notify_bitcoin_approval($user,$units,$ref_no)
     {

          try
          {
     
     $data['user']=$user;
     $data['units']=$units;
     $data['ref_no']=$ref_no;
      Mail::send('emails.bitcoin_approved',$data, function($message) use ($user)
        {
         $message->to($user->email)
         ->bcc("niyibrahym@gmail.com")
         ->from('info@betaexchangeng.com')
            ->subject('Bitcoin order approved!!');
      });

       
     }
         catch(\Exception $e)
          {
            // throw $e;
             return redirect()->back()->withErrors( "Unable to send emails. Pls try again") ->withInput();
            }

     }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
      $bitcoin=BitCoin::find($id);   
        $data['page_title']="Process ";
        $data['page_action']="Activate";
        $data['status']=Utility::Status();
        $data['user']=User::find($bitcoin->user_id);
        $data['bitcoin']=$bitcoin;

    return view('admin.bitcoins.createOrUpdate',$data);
        
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id,Request  $request)
  {

    try {
        $bitcoin = BitCoin::find($id);
     if($bitcoin)
     {
      if($request['status']==null)
      {
     $bitcoin->status = false;
     $bitcoin->save();
      }
      else
      {
     $bitcoin->status =true;
     $bitcoin->save();
    
     $user=User::find($bitcoin->user_id);
     $units=$bitcoin->unit;
     $ref_no=$bitcoin->ref_no;
     $total=$bitcoin->total;

     $this->notify_bitcoin_approval($user,$units,$ref_no);
      }


    }
     return  \Response::json(array('success' => true));
      
    } catch (Exception $e) {
      
    }
    
        $data['page_title']="Edit";
        $data['page_action']="Update";
     return view('admin.bitcoins.createOrUpdate',$data);
  }


  
}

?>