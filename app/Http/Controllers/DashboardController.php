<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;
use App\Helpers\Utility;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Mail;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\BitCoin;
use App\Models\PerfectMoney;
use App\Models\AccountDetail;
use App\Models\PurchaseBitCoin;
use App\Models\PurchasePerfectMoney;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.index');
    }

    public function buy_bitcoin()
    {    
      
         $data['bitcoins']=Bitcoin::where('user_id','=',Auth::user()->id)->get();   
         $data['secret']=strtolower(Auth::user()->account_detail->secret_answer);
         $data['payment_method']=Utility::PaymentMethod(); 
         $data['current_price']=Price::where('id',1)->value('bitcoin');   
        return view('dashboard.buy_bitcoin',$data);
    }



    



    public function save_bitcoin(Request $request)
    {

        try {
            
        
       $input=$request->all();
     
       $user=\Auth::user();

       $postData = $request->all();
       $postData['secret_answer']=strtolower($request['secret_answer']);

       $messages = ['units.required' => 'Enter units',
       'wallet.same' => 'Your confirm wallet id does not match',
       'secret_answer.same' => 'Your secret answer is incorrect of does not match',
       ];

       $rules = ['units' => 'required|numeric',
                 'total_units' => 'required|numeric',
                 'wallet' => 'required|string|max:255',
                 'confirm_wallet' => 'required|string|max:255|same:wallet',
                 'payment_method' => 'required',
                 'secret_answer' => 'required|same:secret'
                ];
            $validator = Validator::make($postData, $rules, $messages);
           if( $validator->fails() ) {
        // Validator fails, return to the previous page with the errors
             return redirect()->back()->withErrors( $validator )->withInput();
           }
      $characters='ABCDEFHJKLMNPQRSTUVWXYZ';  
      $pin=mt_rand(100000,999999).mt_rand(100000,999999).$characters[rand(0,strlen($characters)-3)];
      $ref_no=str_shuffle($pin);

       $next=BitCoin::create([
            'user_id' => $user->id,
            'unit' => $input['units'],
            'total' => $input['total_units'],
            'wallet_id' => $input['wallet'],
            'method' => $input['payment_method'],
            'ref_no' => $ref_no
        ]);

         //$this->send_sms($user->phone_no,'Welcome to Betaexchangeng');
        $this->notify_bitcoin_purchase($user,$input['units'],$ref_no);
 
         }
          catch(ValidationException $e)
          {
            // Rollback and then redirect // back to form with errors
        
        return redirect()->back()->withErrors( $e->getErrors() ) ->withInput();
         }
          catch(\Exception $e)
          {
          
             throw $e;
            }
      return redirect()->intended('/dashboard/buy-bitcoin');
    }



     private function notify_perfect_purchase($user,$units,$ref_no)
     {

          try
          {
     
     $data['user']=$user;
     $data['units']=$units;
     $data['ref_no']=$ref_no;
      Mail::send('emails.buy_perfect_money',$data, function($message) use ($user)
        {
         $message->to("niyibrahym@gmail.com")
         ->bcc('info@betaexchangeng.com')
         ->from('info@betaexchangeng.com')
            ->subject('Perfect Money new order!!');
      });

       
     }
         catch(\Exception $e)
          {
            // throw $e;
             return redirect()->back()->withErrors( "Unable to send emails. Pls try again") ->withInput();
            }

     }



     private function notify_bitcoin_purchase($user,$units,$ref_no)
     {

          try
          {
     
     $data['user']=$user;
     $data['units']=$units;
     $data['ref_no']=$ref_no;
      Mail::send('emails.buy_bitcoin',$data, function($message) use ($user)
        {
         $message->to("niyibrahym@gmail.com")
         ->bcc('info@betaexchangeng.com')
         ->from('info@betaexchangeng.com')
            ->subject('Bitcoin new order!!');
      });

       
     }
         catch(\Exception $e)
          {
            // throw $e;
             return redirect()->back()->withErrors( "Unable to send emails. Pls try again") ->withInput();
            }

     }



     
   private function send_sms($phone_no,$message)
   {
   try {
 
           $client = new GuzzleHttpClient();
 
          
           $apiRequest = $client->request('POST', 'http://www.smsmobile24.com/index.php?option=com_spc&comm=spc_api', [
             'form_params' => [
        'username' => 'BetaX',
        'password' => 'newpassword$',
        'sender' => 'Betaexchangeng.com',
        'recipient' => $phone_no,
        'message' => $message,
        ]
      ]);
           echo $apiRequest->getStatusCode();
           //echo $apiRequest->getHeader('content-type'));
 
         // $content = json_decode($apiRequest->getBody()->getContents());
 
      } catch (RequestException $re) {
          //For handling exception
      }
   }


     public function sell_bitcoin()
    {
        $data['banks']=Utility::GetBanks();
        $data['pm_price']=Price::find(1)->perfect_money_sell;
        $data['bitcoin_price']=Price::find(1)->bitcoin_sell;
        $data['currency_type']=Utility::CurrencyType();
        return view('dashboard.sell_bitcoin',$data);
    }




        public function sell_currency(Request $request)
        {

        try {
            
        
       $input=$request->all();
       if($input["currency_type"]=="Bitcoin")
       {
       $next=PurchaseBitCoin::create([
            'account_name' => $input['account_name'],
            'account_no' => $input['account_no'],
            'bank_name' => $input['bank_name'],
            'phone_no' => $input['phone_no'],
            'email' => $input['email'],
            'unit' => $input['unit'],
            'price' => $input['price1'],
            'total' => $input['total'],
            'wallet_id' => $input['wallet_id'],
            'ref_no' => 1
        ]);
       }
       else if($input["currency_type"]=="Perfect Money")
       {
         $next=PurchasePerfectMoney::create([
            'account_name' => $input['account_name'],
            'account_no' => $input['account_no'],
            'bank_name' => $input['bank_name'],
            'phone_no' => $input['phone_no'],
            'email' => $input['email'],
            'unit' => $input['unit'],
            'price' => $input['price1'],
            'total' => $input['total'],
            'ref_no' => 2
        ]);

       }
       return redirect('/dashboard/sell_bitcoin')->with('status', 'Transaction successfull! Thanks, We shall get in touch soon.');
 
         }
          catch(\Exception $e)
          {
          
             throw $e;
            }
      return redirect()->intended('/how-to-sell');
    }

    public function buy_perfect_money()
    {
         $data['perfects']=PerfectMoney::where('user_id','=',Auth::user()->id)->get();   
         $data['secret']=strtolower(Auth::user()->account_detail->secret_answer);
         $data['payment_method']=Utility::PaymentMethod(); 
         $data['current_price']=Price::where('id',1)->value('perfect_money');   
        return view('dashboard.buy_perfect_money',$data);
    }


    public function save_perfect_money(Request $request)
    {

        try {
            
        
       $input=$request->all();
     
       $user=\Auth::user();

       $postData = $request->all();
       $postData['secret_answer']=strtolower($request['secret_answer']);

       $messages = ['units.required' => 'Enter units',
       'secret_answer.same' => 'Your secret answer is incorrect of does not match',
       ];

       $rules = ['units' => 'required|numeric',
                 'total_units' => 'required|numeric',
                 'account_name' => 'required|string|max:255',
                 'account_no' => 'required|string|max:255',
                 'payment_method' => 'required',
                 'secret_answer' => 'required|same:secret'
                ];
            $validator = Validator::make($postData, $rules, $messages);
           if( $validator->fails() ) {
        // Validator fails, return to the previous page with the errors
             return redirect()->back()->withErrors( $validator )->withInput();
           }
      $characters='ABCDEFHJKLMNPQRSTUVWXYZ';  
      $pin=mt_rand(100000,999999).mt_rand(100000,999999).$characters[rand(0,strlen($characters)-3)];
      $ref_no=str_shuffle($pin);

       $next=PerfectMoney::create([
            'user_id' => $user->id,
            'unit' => $input['units'],
            'total' => $input['total_units'],
            'account_name' => $input['account_name'],
            'account_no' => $input['account_no'],
            'method' => $input['payment_method'],
            'ref_no' => $ref_no
        ]);


        $this->notify_perfect_purchase($user,$input['units'],$ref_no);
 
         }
          catch(ValidationException $e)
          {
            // Rollback and then redirect // back to form with errors
        
        return redirect()->back()->withErrors( $e->getErrors() ) ->withInput();
         }
          catch(\Exception $e)
          {
          
             throw $e;
            }
      return redirect()->intended('/dashboard/buy-perfect-money');
    }

    public function sell_perfect_money()
    {
        return view('dashboard.sell_perfect_money');
    }


    public function buy_currency(Request $request) {
      // $input =  $request->all();
      // echo $input;
      echo "ok";

    }

}
