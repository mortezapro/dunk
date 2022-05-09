<?php

namespace App\Http\Controllers\User;

use App\Models\CartItemModel;
use App\Models\DiscountModel;
use App\Models\ShoppingCartModel;
use App\Models\BookCatModel;
use App\Models\BookModel;
use App\Models\CodesModel;
use App\Models\OrderModel;
use App\Models\QuestionModel;
use App\Models\QuizModel;
use App\Models\RewardcatModel;
use App\Models\UsedDiscountModels;
use App\Models\UserModel;
use App\Models\RequestRewardModel;
use App\Models\RequestmoneyModel;
use App\Models\SettingModel;
use Illuminate\Http\Request;
use App\Models\RewardModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    public $MerchantID;
    public function __construct()
    {
        $this->middleware("VerifyUser");
         $this->middleware("ValidateBack");
             // مرچنت آیدی وزیری :
        $this->MerchantID="eb59ee4a-137d-40aa-8037-80c7f9a568f4";
            // مرچنت آیدی لاراول وب :
        //$this->MerchantID="02255158-172e-11e8-b0a6-000c295eb8fc";

    }
    // مرچنت آیدی لاراول وب :
    //  02255158-172e-11e8-b0a6-000c295eb8fc
    public function pay($Amount,$Email,$Mobile)
    {
        $Description = 'توضیحات تراکنش تستی'; // Required
        $CallbackURL = 'https://jayezedoon.ir/showPayment';
        /*$CallbackURL = 'http://localhost/jayezedoon/public/showPayment'; */ // Required
        $client = new \SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        $result = $client->PaymentRequest(
            [
                'MerchantID' => $this->MerchantID,
                'Amount' => $Amount,
                'Description' => $Description,
                'Email' => $Email,
                'Mobile' => $Mobile,
                'CallbackURL' => $CallbackURL,
            ]
        );
        if ($result->Status == 100) {
            return $result;
        } else {
            return false;
        }
    }
    public function quiz($id=false,Request $request)
    {
        echo $request->session()->get("user_id");
    }

    public function dashboard(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        $user_id = session()->get("user_id");
        $user = DB::table('tbl_users as u')->select(
            'u.user_flname',
            'u.user_name',
            'u.user_coin',
            'tpp.city',
            'tpp.price',
            'u.user_postalcode',
            'u.user_mobile',
            'u.user_city',
            'u.user_address',
            'u.user_image',
            'u.identifier_code'
        )
            ->leftjoin('tbl_price_post as tpp', 'tpp.id', '=', 'u.user_city')
            ->where('u.user_id', $user_id)->first();
        if ($user->user_postalcode == null) $user->user_postalcode = "-";
        if ($user->user_city == null) $user->user_city = "-";
        if ($user->user_address == null) $user->user_address = "-";
        if ($user->user_image == null) $user->user_image = "default.png";
        $disable_coin = SettingModel::first()->convert_coin_state;
        return view("User.Dashboard.Index.Index",compact("user",
            'cats','catRewards',
            "disable_coin",'user_state'));
    }

    public function checkout($book_id,Request $request)
    {
        $activeMenu = "shop";
        $book = BookModel::find($book_id);
        $citys=DB::table('tbl_price_post')->get();
        // dd($citys);
        $user=session()->all();
        return view("User.Checkout.Index",compact("book","user","activeMenu","citys"));
    }

    public function ajaxGetPriceCity(Request $request)
    {
        $city_id = $request->input("city_id");
        $cartTotalDiscount = \Cart::getSubTotal() - \Cart::getTotal();
        $citys=DB::table('tbl_price_post')->where('id',$city_id)->first();
        $cartTotal =  \Cart::getTotal();
        Session::put('city',$citys->price);
        return response()->json(['citys'=>$citys,'cart'=>$cartTotal]);
    }

    public function submitOrder(Request $request)
    {
        $this->validate(request(),[
            'tell'=>'required',
            'city'=>'required',
            'postal_code'=>'required|between:10,10',
            'address'=>'required',
        ],[
            'tell.required'=>'* لطفا شماره موبایل را وارد نمایید',
            'city.required'=>'* لطفا شهر را وارد نمایید',
            'postal_code.required'=>'* لطفا کد پستی را وارد نمایید',
            'postal_code.between'=>'* کد پستی باید ده رقم باشد',
            'address.required'=>'* لطفا آدرس را وارد نمایید',
        ]);
        $user_id = Session::get("user_id");
        $userItem = UserModel::find($user_id);
        $userItem->user_flname=$request->input("name");
        $userItem->user_address=$request->input("address");
        $userItem->user_mobile=$request->input("tell");
        $userItem->user_city=$request->input("city");
        $userItem->user_postalcode=$request->input("postal_code");
        $userItem->save();

        $city_id=$request->input("city");

        /*shopping cart*/
        $shopping_item=new ShoppingCartModel();
        $shopping_item->user_id = $user_id;
        $shopping_item->city_id = $city_id;
        $shopping_item->total_price = \Cart::getTotal();
        $shopping_item->total_price_before_discount = \Cart::getTotal() + Session::get('discount');
        $shopping_item->discount_code = Session::get('discount');
        $shopping_item->save();
        Session::put('shopping_cart_id',$shopping_item->id);

        /*cart item */
        $cartItems = \Cart::getContent();
        foreach ($cartItems as $item) {
            if (is_array($item['conditions']) && !empty($item['conditions'])) {
                $temp = [];
                // get the subtotal with conditions applied
                $item['price_sum'] = $item->getPriceSumWithConditions();

                foreach ($item['conditions'] as $key => $value) {
                    $temp[] = [
                        'name' => $value->getName(),
                        'value' => $value->getValue(),
                    ];
                }

                $item['_conditions'] = $temp;
            }
            $cart_item_data=[
                'product_id'      => $item->id,
                'quantity'        => $item->quantity,
                'price'           => $item->price,
                'shopping_cart_id'=> $shopping_item->id,
            ];
            $cart_Obj = CartItemModel::create($cart_item_data);
        }
        $city_price=DB::table('tbl_price_post')->where('id',$request->input("city"))->first();
        $order_data=[
            'user_id'=>session()->get("user_id"),
            'buy_type'=>1,
            'total_price' => \Cart::getTotal() ,
            'shipping_price' => $city_price->price ,
            'shopping_cart_id' => $shopping_item->id ,
            'tracking_code'=>mt_rand(1111,9999999),
            'order_state'=>0,
            'ref_id'=>0,
            'address'=>$request->input("address"),
            'mobile'=>$request->input("tell"),
            'postal_code'=>$request->input("postal_code"),
            'receiver_name'=>$request->input("name"),
            'city'=> $request->input("city"),
            /* 'description'=>$request->input("desc"),*/
        ];

        $price = (\Cart::getTotal() - (int)Session::get('discount')) + (int)$city_price->price;
        $order_Obj = OrderModel::create($order_data);
        if($order_Obj instanceof OrderModel)
        {
            $result =$this->pay($price,null,null);
            if($result!=false)
            {
                Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result->Authority);
                exit;
            }
            else
            {
                echo'ERR: '.$result->Status;
            }
        }

    }
    public function order_user(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        $user_id = session()->get("user_id");
        $user = UserModel::select(
            'user_flname','user_name','user_coin',
            'user_postalcode','user_mobile','user_city','user_address',
            'user_image','identifier_code'
        )->where('user_id',$user_id)->first();
        if ($user->user_image == null) $user->user_image = "default.png";
//    	$orders = OrderModel::where("user_id",$user_id)
//            ->where("order_state","<>","0")
//            ->with("book")
//            ->orderBy('order_id','desc')
//            ->paginate("10");
        $orders = DB::table("tbl_orders")
            ->join("tbl_books","tbl_books.book_id","=","tbl_orders.book_id")
            ->orderByDesc('order_id')
            ->where("tbl_orders.user_id",$user_id)
            ->get();
        $disable_coin = SettingModel::first()->convert_coin_state;
        return view("User.Dashboard.Order.Index",compact("orders","user",
            "cats",'catRewards',"disable_coin",'user_state'));
    }
    // مرچنت آیدی لاراول وب :
    //  02255158-172e-11e8-b0a6-000c295eb8fc
    public function order(Request $request){

         // لاراول وب
        //$MerchantID = '02255158-172e-11e8-b0a6-000c295eb8fc';

        // وزیری
        $MerchantID = 'eb59ee4a-137d-40aa-8037-80c7f9a568f4';
        $Authority = $_GET['Authority'];
        $user_id = session()->get("user_id");
        $user = UserModel::find($user_id);
        $order = OrderModel::where("user_id",$user_id)->orderby("order_id","desc")->first();
        if ($_GET['Status'] == 'OK') {
            $client = new \SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

            $result = $client->PaymentVerification(
                [
                    'MerchantID' => $MerchantID,
                    'Authority' => $Authority,
                    'Amount' => $order->total_price,
                ]
            );
          // dd($result->Status);
            if ($result->Status == 100) {
                if(Session::has('discount'))
                {
                    $discount = DiscountModel::where('discount_code',Session::get('discount_code'))->first();
                    $used_discount=[
                        'user_id'=>session()->get("user_id"),
                        'code_id'=>$discount->id,
                        'shopping_cart_id'=>Session::get('shopping_cart_id'),
                    ];
                    UsedDiscountModels::create($used_discount);
                }

                $state = 1;
                $user_id = session()->get("user_id");
                $username_current = UserModel::select('user_name')->find($user_id);

                $user = UserModel::find($user_id);

                $user_introduced = $user->introduced;
                if(UserModel::where('user_name',$user_introduced)->count() > 0)
                {
                    $user_identifier_code = UserModel::where('user_name',$user_introduced)->first();

                    if($user_identifier_code->user_name != $username_current->user_name)
                      {
                        if($user_identifier_code instanceof  UserModel)
                        {

                               $coin_sum_identifier = $user_identifier_code->user_coin + SettingModel::first()->coin_identifier;
                            UserModel::where('user_name', $user_introduced)->update(array('user_coin' => $coin_sum_identifier));
                        }

                    }
                }

                $order = OrderModel::where("user_id",$user_id)->orderby("order_id","desc")->first();
                $order->order_state=1;
                $order->ref_id=$result->RefID;
                $order->save();
                return view("Front.Cart.showPayment",compact("order","state","user"));
            }
              elseif ($result->Status == 101) {
                $state = 1;
                $user_id = session()->get("user_id");
                $user = UserModel::find($user_id);

                $user_introduced = $user->introduced;
                $user_identifier_code = UserModel::where('user_name',$user_introduced)->first();
                 if($user_identifier_code instanceof  UserModel)
                {
                        $coin_sum_identifier = $user_identifier_code->user_coin + SettingModel::first()->coin_identifier;
                        UserModel::where('user_name', $user_introduced)->update(array('user_coin' => $coin_sum_identifier));
                }

                $order = OrderModel::where("user_id",$user_id)->orderby("order_id","desc")->first();
                $order->order_state=1;
                $order->ref_id=$result->RefID;
                $order->save();
                return view("Front.Cart.showPayment",compact("order","state","user"));
            }
            else
            {

                $state = 2;
                return view("Front.Cart.showPayment",compact("state","order"));
            }
        }
        else
        {

            $state = 0;
            return view("Front.Cart.showPayment",compact("state","order"));
        }
    }


    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function checkQuizCode(Request $request)
    {
        $this->validate(request(), [
            'book_code' => 'required',
        ], [
            'book_code.required' => '* لطفا کد کتاب را وارد کنید',
        ]);
        $book_code = $request->input("book_code");
        $number_code = preg_replace('/[^0-9]/', '', $book_code);
        $letter_code = preg_replace('/[0-9]/', '', $book_code);
        // $counter = substr($number_code,4);
        // dd($letter_code.$number_code);
        $data = CodesModel::where('code_text', $letter_code)->where('code_number', $number_code)->first();

        if (!empty($data))
        {
            if ($data->quiz_state != 0)
            {
                return redirect()->route("QuizCodeRoute")->with('usedCode',true);
            }
            else
            {
                 $user_id = session()->get("user_id");
                  Session::put('codeBook', $data);
                  $data->update(array('user_id' => $user_id ));
                //$message = QuestionModel::inRandomOrder()->where('quiz_id', $data->quiz_id)->get()->take(3);
                return redirect()->route("matchRoute",["id"=>$data->quiz_id]);
            }
        }

        else return redirect()->route("QuizCodeRoute")->with('mistakeCode',true);
        //go to question page !

    }

    public function raceStart()
    {
        dd("race started");
    }
    public function match($quiz_id=false,Request $request)
    {
        //
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        //
        $codeBook = Session::get('codeBook');
        $code_number = $codeBook->code_number;
        $code_text = $codeBook->code_text;
        $code_model = CodesModel::where('code_number', $code_number)->where('code_text', $code_text)->first();
        if($code_model->quiz_state == 1)
        {
            return redirect()->route("QuizCodeRoute")->with('usedCode',true);
        }
        else
        $quiz = QuizModel::where("quiz_id","=",$quiz_id)->first();
        $startQuestion =  $quiz->quiz_time;
        $start_game_time = time()+$startQuestion*60;
        $second=1;
        $minute=$second*60;
        $hour=$minute*60;
        $day=$hour*24;
        $week=$day*7;
        $time=$start_game_time;
        $offset=time();
        $difference=$time-$offset;
        $hcount=0;
        for($hcount=0; $difference>$hour; $hcount++) {
            $difference=($difference-$hour); }
        $mcount=0;
        for($mcount=0; $difference>$minute;
            $mcount++){
            $difference=$difference-$minute;}
        $countdown=$hcount.':'.$mcount.':'.$difference;
        $quiz = QuizModel::where("quiz_id","=",$quiz_id)->first();
        $codeBook = Session::get('codeBook');
        $code_number = $codeBook->code_number;
        $code_text = $codeBook->code_text;
        CodesModel::where('code_number', $code_number)->where('code_text', $code_text)->update(array('quiz_state' => 1));

        $questions = QuestionModel::inRandomOrder()->where('quiz_id', $quiz_id)->get()->take($quiz->quiz_count);
        // $quiz = QuizModel::where("quiz_id","=",$quiz_id)->first();
        $score = 0;
        return view("User.Match.Index",compact("questions","quiz",'user_state',
            'cats','catRewards',
            "countdown","score"));

    }

    public function matchSubmit(Request $request)
    {
        $quiz_id = $request->input("quiz");
        $quiz = QuizModel::where("quiz_id","=",$quiz_id)->first();
        $quiz_count = $quiz->quiz_count;
        $quiz_score = $quiz->quiz_score;
        $count = 0;
        for($i=1;$i<=$quiz_count;$i++)
        {
            if($request->input("master".$i))
                $que = QuestionModel::find($request->input("master".$i));
            if((($request->input("answer".$i)) == $que->question_answer)&&($request->input("qt".$i)) == $que->question_text)
            {
                $response[] = [$i => true];
                $count = $count+1;
            }
            else
            $response[] = [$i => false , 'answer'=>$que->question_answer];

        }
        $score = ($quiz_score/$quiz_count)*$count;
        $user_id = session()->get("user_id");
        $user = UserModel::find(Session()->get("user_id"));
        $sum_score = $user->user_coin + $score;
        UserModel::where('user_id', $user_id)->update(array('user_coin' => $sum_score));
        $codeBook = Session::get('codeBook');
        $code_number = $codeBook->code_number;
        $code_text = $codeBook->code_text;
        CodesModel::where('code_number', $code_number)->where('code_text', $code_text)->update(array('user_coin' => $score));
        return response()->json([$response, 'score' => $score]);

    }
    public function profile(Request $request)
    {
        $user_state ="";
        $citys=DB::table('tbl_price_post')->get();
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        $user_id = session()->get("user_id");
        $user = DB::table('tbl_users as u')->select(
            'u.user_flname',
            'u.user_name',
            'u.user_coin',
            'tpp.city',
            'u.user_postalcode',
            'u.user_mobile',
            'u.user_city',
            'u.user_address',
            'u.user_image',
            'u.identifier_code'
        )
            ->leftJoin('tbl_price_post as tpp', 'tpp.id', '=', 'u.user_city')
            ->where('u.user_id', $user_id)->first();
        if ($user->user_image == null) $user->user_image = "default.png";
        $disable_coin = SettingModel::first()->convert_coin_state;
        return view("User.Dashboard.Profile.Index",compact("user","user_state","cats",'catRewards',"disable_coin","citys"));
    }

    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postProfileAjax(Request $request)
    {
        $userObj = UserModel::find(Session()->get("user_id"));
        if(request()->file('file'))
        {
            @unlink('images/user/'.$userObj->user_image);
            $user_image= Str::random(45).".".$request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('/user/',$user_image);
            $userData['user_image']=$user_image;
            $userObj->update($userData);
        }
    }
    public function postProfile(Request $request)
    {
        $this->validate(request(),[
            //'tell'=>'required|unique:tbl_users,user_mobile',
            //'user_name'=>'required|unique:tbl_users,user_name',
            'name'=>'required',
            'postal_code'=>'required|between:10,10',
            'tell'=>'required',
            'city'=>'required',
            'address'=>'required',
        ],[
            //'tell.required'=>'* لطفا شماره موبایل را وارد نمایید',
            //'tell.unique'=>'* شماره تلفن تکراری میباشد',
            //'user_name.required'=>'* لطفا نام کاربری را وارد نمایید',
            //'user_name.unique'=>'* نام کاربری تکراری میباشد',
            'name.required'=>'لطفا نام نام خانوادگی را وارد نمایید',
            'postal_code.required'=>'لطفا کد پستی را وارد نمایید',
            'postal_code.between'=>'* کد پستی باید ده رقم باشد',
            'tell.required'=>'لطفا شماره موبایل را وارد نمایید',
            'city.required'=>'لطفا شهر را وارد نمایید',
            'address.required'=>'لطفا آدرس را وارد نمایید',
        ]);
        $userObj = UserModel::find(Session()->get("user_id"));
        $userData=[
            'user_flname'=>$request->input("name"),
            //'user_name'=>$request->input("user_name"),
            'user_postalcode'=>$request->input("postal_code"),
            'user_mobile'=>$request->input("tell"),
            'user_city'=>$request->input("city"),
            'user_address'=>$request->input("address"),
                ];
                    if(request()->file('image'))
                    {
                        @unlink('images/user/'.$userObj->user_image);
                           $user_image= Str::random(45).".".$request->file('image')->getClientOriginalExtension();

                        $request->file('image')->storeAs('/user/',$user_image);
                        $userData['user_image']=$user_image;
                    }
                    $userObj->update($userData);
                    return redirect()->route("profileUserDashboardRoute")->with('successEdit',true);
    }
    public function matchUser(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        $user_id = session()->get("user_id");
        $user = UserModel::select(
            'user_flname','user_name','user_coin',
            'user_postalcode','user_mobile','user_city','user_address',
            'user_image','identifier_code'
        )->where('user_id',$user_id)->first();
        if ($user->user_image == null) $user->user_image = "default.png";
        $matchs = DB::table("tbl_codes")
            ->join("tbl_quiz","tbl_codes.quiz_id","=","tbl_quiz.quiz_id")
            ->select('tbl_codes.code_text','tbl_codes.code_number','tbl_codes.quiz_state','tbl_quiz.quiz_name','tbl_codes.quiz_date','tbl_codes.user_coin')
            ->where('tbl_codes.user_id','=',$user_id)->orderBy('quiz_date','desc')->paginate("10");
            $disable_coin = SettingModel::first()->convert_coin_state;
        return view("User.Dashboard.Match.Index",compact("matchs",
            'user_state',
            'cats','catRewards',
            "user",
            "disable_coin"));
    }
    public function awardUser(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        $user_id = session()->get("user_id");
        $user = UserModel::select(
            'user_flname','user_name','user_coin',
            'user_postalcode','user_mobile','user_city','user_address',
            'user_image','identifier_code'
        )->where('user_id',$user_id)->first();
        if ($user->user_image == null) $user->user_image = "default.png";
        $awards = DB::table("tbl_reward_request")
            ->join("tbl_rewards","tbl_reward_request.reward_id","=","tbl_rewards.reward_id")
            ->select('tbl_rewards.reward_title','tbl_rewards.reward_coin','tbl_reward_request.request_state','tbl_reward_request.request_tracking_code','tbl_rewards.reward_image')
            ->where('tbl_reward_request.user_id','=',$user_id)->orderBy('request_id','desc')->paginate("10");
        $disable_coin = SettingModel::first()->convert_coin_state;
        return view("User.Dashboard.Award.Index",compact("awards","user_state",
            'cats','catRewards',
            "user","disable_coin"));
    }
          public function showCoin()
    {

        $user_id = session()->get("user_id");
        $user_name = UserModel::find($user_id)->user_name;
        $user_image = UserModel::find($user_id)->user_image;
        $user_coin = UserModel::find($user_id)->user_coin;
        $disable_coin = SettingModel::first()->convert_coin_state;
        return view("User.Dashboard.Coin.Index",compact("user_id","user_coin","user_name","user_image","disable_coin"));

    }

       public function changeCoin()
    {

        $user_id = session()->get("user_id");
        $user_coins = RequestmoneyModel::where("request_user_id","=",$user_id)->orderBy('request_id','desc')->paginate("10");
        $user_name = UserModel::find($user_id)->user_name;
        $user_image = UserModel::find($user_id)->user_image;
        $user_coin = UserModel::find($user_id)->user_coin;
        $disable_coin = SettingModel::first()->convert_coin_state;
        $price_coin = SettingModel::first()->price_coin;
        return view("User.Dashboard.ChangeCoin.Index",compact("user_id","user_coin","user_name","user_image","user_coins","disable_coin","price_coin"));

    }
           public function changeCoinSubmit(Request $request)
    {

        $this->validate(request(),[
            'coin'=>'required',

        ],[
            'coin.required'=>'* لطفا تعداد سکه را وارد نمایید',
        ]);
           $user_id = session()->get("user_id");
           $user_coin = UserModel::find($user_id)->user_coin;
           if($request->input("coin")>$user_coin)
           {
               return redirect()->route("changeCoinRoute")->with('successInsert',true);
           }


         $userData=[
            'request_coin'=>$request->input("coin"),
            'request_user_id'=>$request->input("user"),
        ];

        $QuizObj = RequestmoneyModel::create($userData);
        if($QuizObj instanceof RequestmoneyModel)
        {
            return redirect()->route("changeCoinRoute")->with('successInsert',true);
        }

    }

    /**
     * @param Request $request
     * @param bool $id
     * @return $this|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function buy_reward(Request $request, $id=false)
    {
        $this->validate(request(),[
            'mobile'=>'required',
            'postal_code'=>'required',
            'address'=>'required',
            'name'=>'required',
            'city'=>'required',

        ],[
            'mobile.required'=>'* لطفا تلفن همراه را وارد نمایید',
            'postal_code.required'=>'* لطفا کد پستی را وارد نمایید',
            'address.required'=>'* لطفا آدرس را وارد نمایید',
            'name.required'=>'* لطفا نام تحویل گیرنده را وارد نمایید',
            'city.required'=>'* لطفا شهر را وارد نمایید',
        ]);
    	if(cType_digit($id))
    	{
    		$reward = RewardModel::find($id);
    		if($reward instanceof RewardModel)
    		{
    			$user_id = session()->get("user_id");
    			$user = UserModel::find($user_id);
    			if($user->user_coin >= $reward->reward_coin)
    			{
    				$code = mt_rand("111111","999999");
    				$requestRecord=[
    				'reward_id'=>$id,
    				'user_id'=>$user_id,
    				'request_state'=>1,
    				'address'=>$request->input("address"),
    				'mobile'=>$request->input("mobile"),
    				'postal_code'=>$request->input("postal_code"),
    				'receiver_name'=>$request->input("name"),
    				'city'=>$request->input("city"),
                    'request_tracking_code'=>$code,
                    'request_desc'=>$request->input("desc"),
    				];
    				$requestObject = RequestRewardModel::create($requestRecord);
    				{
    					if($requestObject instanceof RequestRewardModel)
    					{
    					$user->user_coin=$user->user_coin-$reward->reward_coin;
	    				$user->save();
	    				return redirect()->back()->with("successBuy",true)->with("tracking_code",$code);
    					}
    				}

    			}
    			else
    			{
    				return redirect()->back()->with("cashError",true);
    			}
    		}
    		else
    		{
    			return redirect()->route("indexRoute");
    		}
    	}
    	else
    	{
    		return redirect()->route("indexRoute");
    	}
    }

    public function rewardCheckout($reward_id=false,Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $catRewards = RewardCatModel::all();
        $cats = BookCatModel::all();
        $reward = RewardModel::find($reward_id);
        $user=session()->all();
        return view("User.Checkout.Reward.Index",compact("reward","user",
            'catRewards','cats',
            'user_state'));
    }
    //saeid
        public function discounter(Request $request)
    {
       
        $user_id =  $request->session()->get("user_id");
		$user = UserModel::find($user_id);
	
		$discount = DiscountModel::where('user_id',$user->user_id)->first();
//	dd($discount);
        $datas = DB::table("tbl_users")
        ->join("tbl_shopping_cart","tbl_shopping_cart.user_id","=","tbl_users.user_id") //جوین کاربر و سبد خرید
        ->join("tbl_cart_items","tbl_cart_items.shopping_cart_id","=","tbl_shopping_cart.id") //جوین ایتم سبذ خرید با سبد خرید
        ->join("tbl_books","tbl_cart_items.product_id","=","tbl_books.book_id") //جوین ایتم سبذ خرید با محصولات
        ->select("tbl_books.book_name as book_name","tbl_cart_items.created_at as created_at","tbl_books.price as price","tbl_users.user_name as user_name","tbl_shopping_cart.discount_code as discount_code")
        ->where('tbl_shopping_cart.discount_code','=',$discount->discount_code)->paginate(50);
//dd( $datas);
		return view("User.Discounter.Index.Index",compact("datas"));
    }
}
