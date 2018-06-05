<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\User;
use Auth;
use App\Helpers\Utility;
use App\Models\Price;
use App\Models\PurchaseBitCoin;
use App\Models\PurchasePerfectMoney;
use App\Models\BlogPost;
use App\Models\BlogComment;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Mail;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data["price"]=Price::first();
        return view('home.index',$data);
    }

     public function getref_code() {
       $characters='ABCDEFHJKLMNPQRSTUVWXYZ';  
      $pin=mt_rand(100000,999999).mt_rand(100000,999999).$characters[rand(0,strlen($characters)-3)];
      $ref_no=str_shuffle($pin);

      return $ref_no;
    }

    public function about()
    {
         
        return view('home.about', $data);
    }

    public function buy()
    {
       // $current_price= Price::where('id',1)->value('bitcoin'); 
         //echo $data;
         $data["price"]=Price::first();
        return view('home.buy', $data);
    }


    public function mybuy()
    {
       // $current_price= Price::where('id',1)->value('bitcoin'); 
         //echo $data;
         $data["price"]=Price::first();
        return view('home.mybuy', $data);
    }



    public function sell()
    {
        $data['banks']=Utility::GetBanks();
        $data['pm_price']=Price::find(1)->perfect_money_sell;
        $data['bitcoin_price']=Price::find(1)->bitcoin_sell;
        $data['currency_type']=Utility::CurrencyType();
        return view('home.sell',$data);
    }

     public function buy_ecurrency()
    {
        $data['banks']=Utility::GetBanks();
        $data['pm_price']=Price::find(1)->perfect_money_buy;
        $data['bitcoin_price']=Price::find(1)->bitcoin_buy;
        $data['currency_type']=Utility::CurrencyType();
        return view('home.buy',$data);
    }

        public function sell_currency(Request $request)
        {
            $data = $request->all();
            $code = $this->generate_code();
            $id = $this->user_id();
            $user_id = $this->checkid($id);
            $ref_no = $this->getref_code();
            //dd($data);

        try {
            
        
       $input=$request->all();

        $saveUser = User::create([
            'first_name' => $input['first_name'],
            'middle_name' => $input['middle_name'],
            'last_name' => $input['last_name'],
            'password' => bcrypt($input['password']),
            'phone_no'=> $input['phone_no'],
            'email'=>$input['email'],
            'verify_code' => $code,
            'user_id'=>$user_id
       ]);

        Auth::login($saveUser);

        if($saveUser){

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
            'ref_no' => $ref_no,
            'user_id' => $user_id
        ]);

      

        $user=array('account_name' =>$input['account_name'] ,       
        'account_no' =>$input['account_no'] ,
        'bank_name' =>$input['bank_name'] ,
        'phone_no' =>$input['phone_no'] ,
        'email' =>$input['email'] ,
        'unit' =>$input['unit'] ,
        'price' =>$input['price1'] ,
        'total' =>$input['total']);

         $this->notify_currency_sales($user,"Bitcoin");
         


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
            'ref_no' => $ref_no,
            'user_id' => $user_id
        ]);
      
          $user=array('account_name' =>$input['account_name'] ,       
        'account_no' =>$input['account_no'] ,
        'bank_name' =>$input['bank_name'] ,
        'phone_no' =>$input['phone_no'] ,
        'email' =>$input['email'] ,
        'unit' =>$input['unit'] ,
        'price' =>$input['price1'] ,
        'total' =>$input['total']);
         $this->notify_currency_sales($user,"Perfect Money");

       }
           }
       return redirect()->intended('dashboard/confirm_order');
 
         }
          catch(\Exception $e)
          {
          
             throw $e;
            }
      return redirect()->intended('/how-to-sell');
    }




    public function contact()
    {
        return view('home.contact');
    }

    public function policy()
    {
        return view('home.policy');
    }

    public function terms()
    {
        return view('home.terms_conditions');
    }

    public function disclamers()
    {
        return view('home.disclamers');
    }

     public function testimonial()
    {
        return view('home.testimonial');
    }
    public function blog()
    {
        $data['posts']=BlogPost::with('comments')->with('user')->get();;
        return view('home.blog',$data);
    }

    public function full_post($id)
    {
         $data['title']='Posts';
         $data['post']=BlogPost::with('comments')->find($id);
      return view('home.full_post',$data);
    }


     public function show_comments_by_post($id)
    {
          $data['comments']=BlogComment::with('user')->
          where('post_id','=',$id)->get();
         return redirect('portal.blog.blog_detail',$data);
    }


    public function save_comment(Request $request)
    {
          $input=$request->all();
         // var_dump($input);
         $input['user_id']=Auth::user()->id;
        BlogComment::create($input);
        return  redirect()->back();
    }



     public function verification()
    {
        return view('home.verify');
    }

    public function next_kin()
    {
       
    }


     public function generate_code() {
        
          $characters='ABCDEFHJKLMNPQRSTUVWXYZ';  
          $pin=mt_rand(100,999).mt_rand(100,999).$characters[rand(0,strlen($characters)-3)];
          $verify_no=str_shuffle($pin);

           return $verify_no;
    }

     private function user_id() {
            $pin=mt_rand(1000,99999);
            $user_no=str_shuffle($pin);
            return $user_no;
            //$this->checkid($user_no);
         }


   private function checkid($gen_id) {
      $exists = User::where('id', $gen_id)->exists();
      if($exists) {
        $this->user_id();
      } else {
        return $gen_id;
      }
   }



    public function account_activation()
    {
        return view('home.account_activation');
    }

    public function login()
    {
        return view('auth.login');
    }


         private function notify_currency_sales($user,$ctype)
        {

          try
          {
     
     $data['user']=$user;
     $data['ctype']=$ctype;
     dd($data);
      Mail::send('emails.sell_currency',$data, function($message)
        {
         $message->to("uchennaanih16@gmail.com")
         ->bcc('info@betaexchangeng.com')
         ->from('info@betaexchangeng.com')
            ->subject('Sell E-currency to us!!');
      });

       
     }
         catch(\Exception $e)
          {
            // throw $e;
             return redirect()->back()->withErrors( "Unable to send emails. Pls try again") ->withInput();
            }

     }

}
