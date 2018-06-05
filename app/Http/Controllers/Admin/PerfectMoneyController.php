<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Helpers\Utility;
use App\Models\PerfectMoney;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Mail;

class PerfectMoneyController extends Controller
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
    $data['perfects']=PerfectMoney::latest('id')->get(); 
   
    return view('admin.perfect_money.index',$data);
  }




    private function perfect_approved($user,$units,$ref_no)
     {

          try
          {
     
     $data['user']=$user;
     $data['units']=$units;
     $data['ref_no']=$ref_no;
      Mail::send('emails.perfect_money_approved',$data, function($message) use ($user)
        {
         $message->to($user->email)
         ->bcc("niyibrahym@gmail.com")
         ->from('info@betaexchangeng.com')
            ->subject('Perfect Money order approved!!');
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
      $perfect=PerfectMoney::find($id);   
        $data['page_title']="Process ";
        $data['page_action']="Activate";
        $data['status']=Utility::Status();
        $data['user']=User::find($perfect->user_id);
        $data['perfect']=$perfect;

    return view('admin.perfect_money.createOrUpdate',$data);
        
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
        $perfect = PerfectMoney::find($id);
     if($perfect)
     {
      if($request['status']==null)
      {
     $perfect->status = false;
     $perfect->save();
      }
      else
      {
    $perfect->status =true;
     $perfect->save();

     $user=User::find($perfect->user_id);
     $units=$perfect->unit;
     $ref_no=$perfect->ref_no;
     $total=$perfect->total;
     $this->perfect_approved($user,$units,$ref_no);
      }


    }
     return  \Response::json(array('success' => true));
      
    } catch (Exception $e) {
      
    }
    
        $data['page_title']="Edit";
        $data['page_action']="Update";
     return view('admin.perfect_money.createOrUpdate',$data);
  }


  
}

?>