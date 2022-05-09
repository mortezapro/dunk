<?php

namespace App\Http\Controllers\Front;

use App\Models\BookModel;
use App\Models\CategoryPostModel;
use App\Models\CityPostModel;
use App\Models\CodesModel;
use App\Models\CommentModel;
use App\Models\DiscountModel;
use App\Models\MessageModel;
use App\Models\PostModel;
use App\Models\QuestionModel;
use App\Models\BookCatModel;
use App\Models\SettingModel;
use App\Models\SliderModel;
use App\Models\ShopSliderModel;
use App\Models\UserModel;
use App\Models\RewardModel;
use App\Models\RewardcatModel;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use IPPanel\Client;
use IPPanel\Errors\Error;
use IPPanel\Errors\HttpException;
use IPPanel\Errors\ResponseCodes;
use Carbon\Carbon;


require_once __DIR__ . '/../../../../vendor/autoload.php';

class FrontController extends Controller
{
    public function index(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $activeMenu = "index";
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        $sliders = ShopSliderModel::all();
        $setting = SettingModel::first();
        $products= BookModel::where('anbar','موجود')->orderby("book_id", "DESC")->get()->take(15);
        $random= BookModel::where('anbar','موجود')->inRandomOrder()->limit(2)->get();
        $rewards = RewardModel::where('anbar','موجود')->orderBy("reward_id","DESC")->get()->take(15);
        return view('Front.Home.Index',compact("sliders","activeMenu",'user_state',"setting","random",
            "products","rewards","cats","catRewards"));
    }
    public function ajax_cat_shop(Request $request)
    {
//        $products=BookModel::where('book_cat_id',$cat_id)->paginate(8);
//        if ($cat_id=="all"){
//            $products= BookModel::where('anbar','موجود')->orderby("book_id", "DESC")->paginate(8);
//        }
        $products = DB::table("tbl_books")
            ->join("tbl_book_cat_join","tbl_book_cat_join.book_id","=","tbl_books.book_id")
            ->whereIn('tbl_book_cat_join.category_id',$request->input('categories'))
            ->where('anbar','موجود')
            ->paginate(12);
        return view('Front.Shop.ajax', compact('products'))->render();
    }

    public function cart()  {
        $user_state ="";
        $user_id = Session::get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $catRewards = RewardCatModel::all();
        $cats=BookCatModel::all();
        $cartCollection = \Cart::getContent();
        return view('Front.Cart.basket')->with(['cartCollection' => $cartCollection,'cats'=>$cats,'catRewards'=>$catRewards,'user_state'=>$user_state]);
    }
    public function addCart(Request $request){

        \Cart::add(array(
            'id' => $request->book_id,
            'name' => $request->book_name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->book_image,
            )
        ));
        return redirect()->route('cartRoute')->with('success_msg', 'محصول مورد نظر به سبد خرید اضافه شد.');
    }
    public function removeCart(Request $request){
        \Cart::remove($request->id);
        return redirect()->route('cartRoute')->with('success_msg', 'محصول مورد نظر با موفقیت حذف شد.');
    }

    public function updateCart(Request $request){
        \Cart::update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
            ));
        return redirect()->route('cartRoute')->with('success_msg', 'سبد خرید به روز شده است.');
    }
    public function ajaxUpdateCart(Request $request){
        $quantity = $request->quantity;
        $update =  \Cart::update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
            ));

        $cartCollection = \Cart::getContent();
        $cartTotalCount = \Cart::getTotalQuantity();

        $percent = Session::get('discount_percent');
        $percent_struct ='-'.$percent.'%';
        $message_discount = $percent." درصد تخفیف ";
        $condition = new \Darryldecode\Cart\CartCondition([
            'name' => 'TAX 12% VAT',
            'type' => 'tax' ,
            'target' => 'total',
            'value' => $percent_struct
        ]);

        $cartTotalDiscount = \Cart::getSubTotal() - \Cart::getTotal();
        $cartTotal =  \Cart::getTotal();
        $conditions = \Cart::getConditions()->put($condition->getName(), $condition)->toArray();
        \Cart::condition($conditions);
        return response()->json([$cartCollection,$cartTotal,$cartTotalCount,$cartTotalDiscount]);

    }
    public function clearCart(){
        \Cart::clear();
        return redirect()->route('cartRoute')->with('success_msg', 'سبد خرید خالی است!');
    }

    public function ajaxUpdateDiscountPrice(Request $request)
    {
        Session::put('discount',$request->discount);
        $discount = DiscountModel::where('discount_code',$request->discount)->whereDate('from_date', '<=', date('Y-m-d H:i:s'))->whereDate('to_date', '>=', date('Y-m-d H:i:s'))->where('status',1)->first();
        //dd($discount);
        if($discount instanceof DiscountModel)
        {
          
            $cartTotal = \Cart::getSubTotal() - \Cart::getTotal();
            //dd($cartTotal);
            $percent = $discount->percent;
            Session::put('discount_percent',$percent);
            $percent_struct ='-'.$percent.'%';
            $message_discount = $percent." درصد تخفیف ";
            Session::put('message_discount',$message_discount);
            $condition = new \Darryldecode\Cart\CartCondition([
                'name' => 'TAX 12% VAT',
                'type' => 'tax' ,
                'target' => 'total',
                'value' => $percent_struct
            ]);
            $conditions = \Cart::getConditions()->put($condition->getName(), $condition)->toArray();
            \Cart::condition($conditions);
            if(Session::has('city') !== null)
            {
                $total_amount = \Cart::getTotal() + (int)Session::get('city');
            }
            else
            {
                $user_id = session()->get("user_id");
                $user = DB::table('tbl_users')->where('user_id',$user_id)->first();
                $citys=DB::table('tbl_price_post')->where('id',$user->user_city)->first();
                $total_amount = \Cart::getTotal();
            }
            return response()->json(['cartTotal'=>$cartTotal,'total_amount'=>$total_amount,'message_discount'=>$message_discount]);

        }
        else{
            $condition = new \Darryldecode\Cart\CartCondition([
                'name' => 'TAX 12% VAT',
                'type' => 'tax' ,
                'target' => 'total',
                'value' => '0%'
            ]);
            $conditions = \Cart::getConditions()->put($condition->getName(), $condition)->toArray();
            \Cart::condition($conditions);
            if(Session::has('city'))
            {
                $total_amount = \Cart::getTotal() + (int)Session::get('city');
            }
            else
            {
                $user_id = session()->get("user_id");
                $user = DB::table('tbl_users')->where('user_id',$user_id)->first();
                $citys=DB::table('tbl_price_post')->where('id',$user->user_city)->first();
                $total_amount = \Cart::getTotal() + (int)$citys->price;
            }
            return response()->json(['cartTotal'=>0,'total_amount'=>$total_amount,'message_discount'=>'']);
        }
    }

    public function shipping()
    {
        $user_state ="";
        $user_id = Session::get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        if(Session::get('discount'))
        {
            $cartPrice = \Cart::getTotal();
            $discount = Session::get('discount');
            $cartTotal = (int)$cartPrice - (int)$discount;
        }
        else
        {
            $cartPrice = \Cart::getTotal();
            $discount = 0;
            $cartTotal = \Cart::getTotal();
        }
        $activeMenu = "shop";
        $citys=DB::table('tbl_price_post')->get();
        // dd($citys);
        $user_id = session()->get("user_id");
        $cartCollection = \Cart::getContent();
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
        if($user->price != null || $user->price != "")
        {
            $cartTotal = $user->price + $cartTotal;

        }
        return view('Front.Cart.shipping',compact('citys','user','cartCollection','cartPrice','cartTotal','discount','user_state'));
    }

    public function cat_shop($cat_id,Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $activeMenu = "shop";
        $sliders = ShopSliderModel::all();
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        $new_products= BookModel::select("book_name", "price", "coin","book_id","book_image")->where('anbar','موجود')->orderby("book_id", "asc")->get(8);

        //$products=BookModel::whereIn('book_cat_id',explode(',',$cat_id))->paginate(12);

        $products = DB::table("tbl_books")
            ->join("tbl_book_cat_join","tbl_book_cat_join.book_id","=","tbl_books.book_id")
            ->whereIn('tbl_book_cat_join.category_id',explode(',',$cat_id))
             ->where('anbar','موجود')
            ->paginate(12);

        return view('Front.Shop.Index',compact('cats','new_products',"products",'user_state',
        "sliders","activeMenu","catRewards"));
    }
    public function shop(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $activeMenu = "shop";
        $products= BookModel::where('anbar','موجود')->orderby("book_id", "DESC")->paginate(12);

        return view('Front.Shop.Index',compact("products","activeMenu"));
    }

    public function blogFilter(Request $request)
    {
        $filtered = true;
        $searchText = $request->input("searchText");
        $categoryIds = $request->input("cats_blog");
        $resultId=[];
        if($request->input("allCat") || (!$request->input("allCat")) &&  !$request->input("cats_blog"))
        {
            $catBlogs = CategoryPostModel::all();
            foreach ($catBlogs as $item) {
                array_push($resultId,$item->category_id);
            }
            $categoryIds = $resultId;
        }else{
            $catBlogs = CategoryPostModel::all();
        }
        $activeMenu = "blog";
        $blogs = DB::table('tbl_posts')
            ->join('tbl_post_category','tbl_post_category.category_id','=','tbl_posts.category_id')
            ->select('tbl_posts.status as status','tbl_posts.id as id','tbl_posts.title as title','tbl_posts.media as media','tbl_posts.created_at as date','tbl_post_category.category_name as category')
            ->orderByDesc('id')
            ->where("tbl_posts.title",'like',"%" . $searchText . "%")
            ->whereIn('tbl_posts.category_id',$categoryIds)
            ->paginate(12)
            ->appends(request()->query());
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        return view('Front.Blog.Index',compact('filtered',"blogs",'categoryIds',"catRewards",'catBlogs',"cats","activeMenu",'user_state','searchText'));
    }

    public function shopFilter(Request $request)
    {

        $filtered = true;
        $bookName = $request->input("search_book");
        $categoryIds = $request->input("cats_book");
        $resultId=[];
        $exist=false;
        $filterType = $request->input("filterType");
        if($request->input("allCat") || (!$request->input("allCat")) &&  !$request->input("cats_book")){
            $arrayList = BookCatModel::all();
            foreach ($arrayList as $item) {
                array_push($resultId,$item->category_id);
            }
            $categoryIds = $resultId;
        }
        $activeMenu = "shop";
        if($request->input("exist")){
            $exist=true;
            if($filterType=="cheap"){
                $products = DB::table("tbl_books")
                    ->leftJoin("tbl_book_cat_join","tbl_book_cat_join.book_id","=","tbl_books.book_id")
                    ->where("tbl_books.book_name",'like',"%" . $bookName . "%")
                    ->where("tbl_books.anbar",'=',"موجود")
                    ->whereIn('tbl_book_cat_join.category_id',$categoryIds)
                    ->orderby("price","asc")
                    ->groupBy('tbl_books.book_id')
                    ->paginate(12);
                   // ->appends(request()->query());
            }
            if($filterType=="expensive"){
                $products = DB::table("tbl_books")
                    ->leftJoin("tbl_book_cat_join","tbl_book_cat_join.book_id","=","tbl_books.book_id")
                    ->where("tbl_books.book_name",'like',"%" . $bookName . "%")
                    ->where("tbl_books.anbar",'=',"موجود")
                    ->whereIn('tbl_book_cat_join.category_id',$categoryIds)
                    ->orderby("price","desc")
                     ->groupBy('tbl_books.book_id')
                    ->paginate(12);
                  //  ->appends(request()->query());
            }
            if($filterType=="new" || $filterType==null){
                $products = DB::table("tbl_books")
                    ->leftJoin("tbl_book_cat_join","tbl_book_cat_join.book_id","=","tbl_books.book_id")
                    ->where("tbl_books.book_name",'like',"%" . $bookName . "%")
                    ->where("tbl_books.anbar",'=',"موجود")
                    ->whereIn('tbl_book_cat_join.category_id',$categoryIds)
                     ->groupBy('tbl_books.book_id')
                    ->orderby("id","desc")
                    ->paginate(12);
                   // ->appends(request()->query());
            }
        } else {
            if($filterType=="cheap"){
                $products = DB::table("tbl_books")
                    ->leftJoin("tbl_book_cat_join","tbl_book_cat_join.book_id","=","tbl_books.book_id")
                    ->where("tbl_books.book_name",'like',"%" . $bookName . "%")
                    ->where("tbl_books.anbar",'=',"موجود")
                    ->whereIn('tbl_book_cat_join.category_id',$categoryIds)
                     ->groupBy('tbl_books.book_id')
                    ->orderby("price","asc")
                    ->paginate(12);
                    //->appends(request()->query());
            }
            elseif($filterType=="expensive"){
                $products = DB::table("tbl_books")
                    ->leftJoin("tbl_book_cat_join","tbl_book_cat_join.book_id","=","tbl_books.book_id")
                    ->where("tbl_books.book_name",'like',"%" . $bookName . "%")
                    ->where("tbl_books.anbar",'=',"موجود")
                    ->whereIn('tbl_book_cat_join.category_id',$categoryIds)
                     ->groupBy('tbl_books.book_id')
                    ->orderby("price","desc")
                    ->paginate(12);
                  //  ->appends(request()->query());

            }
            elseif($filterType=="new" || $filterType==null){
                $products = DB::table("tbl_books")
                    ->leftJoin("tbl_book_cat_join","tbl_book_cat_join.book_id","=","tbl_books.book_id")
                    ->where("tbl_books.book_name",'like',"%" . $bookName . "%")
                    ->where("tbl_books.anbar",'=',"موجود")
                    ->whereIn('tbl_book_cat_join.category_id',$categoryIds)
                     ->groupBy('tbl_books.book_id')
                    ->orderby("id","desc")
                    ->paginate(12);
                   // ->appends(request()->query());
            }
        }
        return view('Front.Shop.Index',compact("products","activeMenu","bookName","categoryIds","filtered","exist","filterType"));
    }

        public function rewardFilter(Request $request)
    {
        $filtered = true;
        $rewardName = $request->input("search_name_reward");
        $rewardCoin = $request->input("search_coin_reward");
        $categoryIds = $request->input("cats_reward");
        $resultId=[];
        $exist=false;
        $filterType = $request->input("filterType");
        if($request->input("allCat") || (!$request->input("allCat")) &&  !$request->input("cats_reward")){
            $arrayList = RewardcatModel::all();
            foreach ($arrayList as $item) {
                array_push($resultId,$item->cat_id);
            }
            $categoryIds = $resultId;
        }
        $activeMenu = "shop";
        if($request->input("exist")){
            $exist=true;
            if($filterType=="cheap"){
                if($request->input("search_coin_reward"))
                    $rewards = DB::table("tbl_rewards")
                        ->leftJoin("tbl_reward_cat","tbl_rewards.cat_id","=","tbl_reward_cat.cat_id")
                        ->where("tbl_rewards.reward_title",'like',"%" . $rewardName . "%")
                        ->where('tbl_rewards.reward_coin', '<=', $rewardCoin)
                        ->where("tbl_rewards.anbar",'=',"موجود")
                        ->whereIn('tbl_reward_cat.cat_id',$categoryIds)
                        ->orderby("reward_coin","asc")
                        ->paginate(12)
                        ->appends(request()->query());
                else
                    $rewards = DB::table("tbl_rewards")
                        ->leftJoin("tbl_reward_cat","tbl_rewards.cat_id","=","tbl_reward_cat.cat_id")
                        ->where("tbl_rewards.reward_title",'like',"%" . $rewardName . "%")
                        ->where("tbl_rewards.anbar",'=',"موجود")
                        ->whereIn('tbl_reward_cat.cat_id',$categoryIds)
                        ->orderby("reward_coin","asc")
                        ->paginate(12)
                        ->appends(request()->query());
            }
            if($filterType=="expensive"){
                if($request->input("search_coin_reward"))
                    $rewards = DB::table("tbl_rewards")
                        ->leftJoin("tbl_reward_cat","tbl_rewards.cat_id","=","tbl_reward_cat.cat_id")
                        ->where("tbl_rewards.reward_title",'like',"%" . $rewardName . "%")
                        ->where('tbl_rewards.reward_coin', '<=', $rewardCoin)
                        ->where("tbl_rewards.anbar",'=',"موجود")
                        ->whereIn('tbl_reward_cat.cat_id',$categoryIds)
                        ->orderby("reward_coin","desc")
                        ->paginate(12)
                        ->appends(request()->query());
                else
                    $rewards = DB::table("tbl_rewards")
                    ->leftJoin("tbl_reward_cat","tbl_rewards.cat_id","=","tbl_reward_cat.cat_id")
                    ->where("tbl_rewards.reward_title",'like',"%" . $rewardName . "%")
                    ->where("tbl_rewards.anbar",'=',"موجود")
                    ->whereIn('tbl_reward_cat.cat_id',$categoryIds)
                    ->orderby("reward_coin","desc")
                    ->paginate(12)
                    ->appends(request()->query());
            }
            if($filterType=="new" || $filterType==null){
                if($request->input("search_coin_reward"))
                    $rewards = DB::table("tbl_rewards")
                        ->leftJoin("tbl_reward_cat","tbl_rewards.cat_id","=","tbl_reward_cat.cat_id")
                        ->where("tbl_rewards.reward_title",'like',"%" . $rewardName . "%")
                        ->where('tbl_rewards.reward_coin', '<=', $rewardCoin)
                        ->where("tbl_rewards.anbar",'=',"موجود")
                        ->whereIn('tbl_reward_cat.cat_id',$categoryIds)
                        ->orderby("tbl_rewards.reward_id","desc")
                        ->paginate(12)
                        ->appends(request()->query());
                else
                    $rewards = DB::table("tbl_rewards")
                    ->leftJoin("tbl_reward_cat","tbl_rewards.cat_id","=","tbl_reward_cat.cat_id")
                    ->where("tbl_rewards.reward_title",'like',"%" . $rewardName . "%")
                    ->where("tbl_rewards.anbar",'=',"موجود")
                    ->whereIn('tbl_reward_cat.cat_id',$categoryIds)
                    ->orderby("tbl_rewards.reward_id","desc")
                    ->paginate(12)
                    ->appends(request()->query());
            }
        } else {
            if($filterType=="cheap"){
                if($request->input("search_coin_reward"))
                    $rewards = DB::table("tbl_rewards")
                        ->leftJoin("tbl_reward_cat","tbl_rewards.cat_id","=","tbl_reward_cat.cat_id")
                        ->where("tbl_rewards.reward_title",'like',"%" . $rewardName . "%")
                        ->where('tbl_rewards.reward_coin', '<=', $rewardCoin)
                        ->where("tbl_rewards.anbar",'=',"موجود")
                        ->whereIn('tbl_reward_cat.cat_id',$categoryIds)
                        ->orderby("reward_coin","asc")
                        ->paginate(12)
                        ->appends(request()->query());
                    else
                        $rewards = DB::table("tbl_rewards")
                        ->leftJoin("tbl_reward_cat","tbl_rewards.cat_id","=","tbl_reward_cat.cat_id")
                        ->where("tbl_rewards.reward_title",'like',"%" . $rewardName . "%")
                        ->where("tbl_rewards.anbar",'=',"موجود")
                        ->whereIn('tbl_reward_cat.cat_id',$categoryIds)
                        ->orderby("reward_coin","asc")
                        ->paginate(12)
                        ->appends(request()->query());
            }
            elseif($filterType=="expensive"){
                if($request->input("search_coin_reward"))
                     $rewards = DB::table("tbl_rewards")
                        ->leftJoin("tbl_reward_cat","tbl_rewards.cat_id","=","tbl_reward_cat.cat_id")
                        ->where("tbl_rewards.reward_title",'like',"%" . $rewardName . "%")
                        ->where('tbl_rewards.reward_coin', '<=', $rewardCoin)
                        ->where("tbl_rewards.anbar",'=',"موجود")
                        ->whereIn('tbl_reward_cat.cat_id',$categoryIds)
                        ->orderby("reward_coin","desc")
                        ->paginate(12)
                        ->appends(request()->query());
                else
                    $rewards = DB::table("tbl_rewards")
                    ->leftJoin("tbl_reward_cat","tbl_rewards.cat_id","=","tbl_reward_cat.cat_id")
                    ->where("tbl_rewards.reward_title",'like',"%" . $rewardName . "%")
                    ->where("tbl_rewards.anbar",'=',"موجود")
                    ->whereIn('tbl_reward_cat.cat_id',$categoryIds)
                    ->orderby("reward_coin","desc")
                    ->paginate(12)
                    ->appends(request()->query());

            }
            elseif($filterType=="new" || $filterType==null){
                if($request->input("search_coin_reward"))
                     $rewards = DB::table("tbl_rewards")
                        ->leftJoin("tbl_reward_cat","tbl_rewards.cat_id","=","tbl_reward_cat.cat_id")
                        ->where("tbl_rewards.reward_title",'like',"%" . $rewardName . "%")
                        ->where('tbl_rewards.reward_coin', '<=', $rewardCoin)
                        ->where("tbl_rewards.anbar",'=',"موجود")
                        ->whereIn('tbl_reward_cat.cat_id',$categoryIds)
                        ->orderby("tbl_rewards.reward_id","desc")
                        ->paginate(12)
                        ->appends(request()->query());
                else
                     $rewards = DB::table("tbl_rewards")
                    ->leftJoin("tbl_reward_cat","tbl_rewards.cat_id","=","tbl_reward_cat.cat_id")
                    ->where("tbl_rewards.reward_title",'like',"%" . $rewardName . "%")
                    ->where("tbl_rewards.anbar",'=',"موجود")
                    ->whereIn('tbl_reward_cat.cat_id',$categoryIds)
                    ->orderby("tbl_rewards.reward_id","desc")
                    ->paginate(12)
                    ->appends(request()->query());
            }
        }
        return view('Front.Reward.Index',compact("rewards","activeMenu","rewardName","rewardCoin","categoryIds","filtered","exist","filterType"));
    }

    public function book($book_id=false,Request $request)
    {
        $activeMenu = "shop";
        //dd($request->session());
        $user_state ="";
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        $user_id = $request->session()->get("user_id");
        if($user_id!=null)
        {
            $user_state ="logined";
        }
        $book_cats = DB::table('tbl_book_cat_join')->select('category_id')
            ->where('book_id', $book_id)
            ->orderByDesc('id')
            ->get();
        $arr_cat=array();
        foreach($book_cats as $item1)
        {
            array_push($arr_cat,$item1->category_id);
        }
        $book = BookModel::where("book_id","=",$book_id)->first();
        $book_related = BookModel::where('book_cat_id',$book->book_cat_id)->orderby("book_id", "DESC")->paginate(12);

        //  get comment kazemi
        //  what is session?
        //return view('Front.Shop.Single',compact('book',"session","user_state","activeMenu"));

        $comments = DB::table('tbl_books')
            ->join('tbl_comments','tbl_books.book_id','=','tbl_comments.foreign_id')
            ->leftJoin('tbl_users','tbl_users.user_id','=','tbl_comments.user_id')
            ->select('tbl_users.user_flname',
                'tbl_comments.text',
                'tbl_comments.created_at')
            ->where('tbl_comments.type',2)
            ->where('tbl_comments.foreign_id',$book_id)
            ->where('tbl_comments.status',1)
            ->paginate(10);



        return view('Front.Shop.Single',compact('book','book_related',"cats","comments",'arr_cat',
            'catRewards',"user_state","activeMenu"));
    }
    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function searchBook(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $activeMenu = "shop";
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        $sliders = ShopSliderModel::all();
        $book = $_GET['search_book'];
        $new_products= BookModel::where("tbl_books.anbar",'=',"موجود")->select("book_name", "price", "coin","book_id","book_image")->orderBy("book_id", "asc")->get(12);
        $products= BookModel::Where('book_name', 'like', '%' . $book . '%')->orderBy("book_id","DESC")->paginate(12);
        $products->appends(['search_book' => $book]);
        return view('Front.Shop.Index',compact('cats','new_products','user_state','catRewards',
            "products","sliders","activeMenu"));
    }

    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function searchRewardByName(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $activeMenu = "reward";
         $reward = $_GET['search_name_reward'];
        $cats=BookCatModel::all();
         $catRewards = RewardCatModel::all();
        $rewards= RewardModel::where("anbar",'=',"موجود")->Where('reward_title', 'like', '%' . $reward . '%')->orderBy("reward_id","DESC")->paginate(12);
        $rewards->appends(['search_name_reward' => $reward ]);
	    return view('Front.Reward.Index',compact("rewards",'user_state','cats',
            "catRewards","activeMenu"));
    }
    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */

    public function searchRewardByCoint(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $activeMenu = "reward";
        $reward = $_GET['search_coin_reward'];
        $cats=BookCatModel::all();
         $catRewards = RewardCatModel::all();
        $rewards= RewardModel::Where('reward_coin', '<', $reward)->orderBy("reward_coin","DESC")->paginate(12);
	 $rewards->appends(['search_coin_reward' => $reward ]);
	return view('Front.Reward.Index',compact("rewards",'user_state','cats',
        "catRewards","activeMenu"));
    }

    public function reward(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $activeMenu = "reward";
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        $rewards= RewardModel::where("anbar",'=',"موجود")->orderBy("reward_id","DESC")->paginate(12);
        return view('Front.Reward.Index',compact("rewards","catRewards","cats","activeMenu",'user_state'));
    }

    public function single_reward($id = false,Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $activeMenu = "reward";
    	if(ctype_digit($id))
    	{
            $cats=BookCatModel::all();
            $catRewards = RewardCatModel::all();
    		$reward= RewardModel::where("reward_id",$id)->first();
    		$cat_reward_name = RewardCatModel::where("cat_id",$reward->cat_id)->first();
    		$reward_related= RewardModel::where('cat_id',$reward->cat_id)->orderby("reward_id", "DESC")->paginate(8);
            $comments = DB::table('tbl_rewards')
                ->join('tbl_comments','tbl_rewards.reward_id','=','tbl_comments.foreign_id')
                ->leftJoin('tbl_users','tbl_users.user_id','=','tbl_comments.user_id')
                ->select('tbl_users.user_flname',
                    'tbl_comments.text',
                    'tbl_comments.created_at')
                ->where('tbl_comments.type',3)
                ->where('tbl_comments.foreign_id',$id)
                ->where('tbl_comments.status',1)
                ->paginate(10);
    		if($reward != null)
    		{
                 return view('Front.Reward.Single',compact("reward",'cats','user_state','comments',
                     'cat_reward_name', 'catRewards','reward_related',"activeMenu"));
    		}

    	}
    }
    public function cat_reward($id = false,Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
           $activeMenu = "reward";
           $catRewards = RewardCatModel::all();
           $cats = BookCatModel::all();
           $rewards= RewardModel::where("anbar",'=',"موجود")->where("cat_id",$id)->orderBy("reward_id","DESC")->paginate("6");
           return view('Front.Reward.Index',compact("rewards","catRewards","activeMenu",'user_state','cats'));
    }

    public function ajax_cat_reward($id = false)
    {
        $rewards= RewardModel::where("anbar",'=',"موجود")->where("cat_id",$id)->orderBy("reward_id","DESC")->paginate(12);
        if ($id=="all"){
            $rewards= RewardModel::where("anbar",'=',"موجود")->orderBy("reward_id","DESC")->paginate(12);
        }
        return view('Front.Reward.ajax', compact('rewards'))->render();
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
                //$message = QuestionModel::inRandomOrder()->where('quiz_id', $data->quiz_id)->get()->take(3);
                return redirect()->route("QuizRoute",["code_id"=>$data->code_id,"quiz_id"=>$data->quiz_id]);
            }
        }
        else return redirect()->route("QuizCodeRoute")->with('mistakeCode',true);
        //go to question page !

    }

    public function register($type=false,$id=false)
    {
        $activeMenu = "register";
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        return view("Front.Register.Index",compact("type","id","activeMenu",'cats','catRewards'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function doRegister(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'tell' => 'required|unique:tbl_users,user_mobile',
            'username' => 'required|unique:tbl_users,user_name',
            'password' => 'required|confirmed|min:6',
            'confirmation' => 'required',
            'captcha' => 'required|captcha',

        ], [
            'name.required' => '* لطفا نام و نام خانوادگی را وارد کنید',
            'tell.required' => '* لطفا  تلفن تماس را وارد کنید',
            'username.required' => '* لطفا نام کاربری را وارد کنید',
            'username.unique' => '* نام کاربری تکراری است',
            'tell.unique' => '* تلفن تماس تکراری است',
            'password.required' => '* لطفا رمز عبور را وارد کنید',
            'password.confirmed' => '* رمزهای عبور مطابقت ندارند',
            'password.min' => '* رمز عبور حداقل باید حاوی ۶ کاراکتر باشد',
            'captcha.required' => '* لطفا کد امنیتی را وارد کنید',
            'captcha.captcha' => '* کد امنیتی اشتباه است',
            'confirmation.required' => '* قوانین سایت را تایید کنید',
        ]);
        $password= $request->input("password")."ascvrtye43";
        $type = $request->input("type");
        $typeId = $request->input("typeId");
        $newPassword = md5($password);
        $userRecord = [
            'user_mobile'=>$request->input("tell"),
            'user_flname'=>$request->input("name"),
            'user_name'=>$request->input("username"),
            'user_password'=>$newPassword,
            'introduced'=>$request->input("introduced"),
            'identifier_code'=>$request->input("username"),
        ];
        $userObj = UserModel::create($userRecord);
        if($userObj instanceof UserModel)
        {
            $request->session()->put('username', $userObj->user_name);
            $request->session()->put('user_id', $userObj->user_id);
            $request->session()->put('user_flname', $userObj->user_flname);
            $request->session()->put('user_coin', $userObj->user_coin);
            $request->session()->put('user_postalcode', $userObj->user_postalcode);
            $request->session()->put('user_mobile', $userObj->user_mobile);
            $request->session()->put('user_city', $userObj->user_city);
            $request->session()->put('user_address', $userObj->user_address);
            $request->session()->put('user_image', $userObj->user_image);
            if($type == "basket")
                return redirect()->route("shippingRoute")->with('successLogin',true);
            if($type == "quiz")
                  return redirect()->route("QuizCodeRoute")->with('successLogin',true);
            if($type == "reward")
                 return redirect()->route("singleRewardRoute",["id"=>$typeId])->with('successLogin',true);
            if($type == "book")
                 return redirect()->route("singleBookRoute",["id"=>$typeId])->with('successLogin',true);
            if($type == false)
                 return redirect()->route("indexRoute")->with('successLogin',true);

        }
    }

    public function login(Request $request)
    {
        $activeMenu = "logins";
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        $access_route = $request->access;
        return view("Front.Login.Index",compact("activeMenu",'cats','catRewards','access_route'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function doLogin(Request $request)
    {
        $this->validate(request(), [
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ], [
            'username.required' => '* لطفا نام کاربری را وارد کنید',
            'password.required' => '* لطفا رمز عبور را وارد کنید',
            'captcha.required' => '* لطفا کد امنیتی را وارد کنید',
            'captcha.captcha' => '* کد امنیتی اشتباه است',
        ]);
        $password= md5($request->input("password")."ascvrtye43");

        $userObject =UserModel::where("user_name","=",$request->input("username"))->where("user_password","=",$password)->first();

        if($userObject instanceof  UserModel)
        {

            $request->session()->put('username', $userObject->user_name);
            $request->session()->put('user_id', $userObject->user_id);
            $request->session()->put('user_flname', $userObject->user_flname);
            $request->session()->put('user_coin', $userObject->user_coin);
            $request->session()->put('user_postalcode', $userObject->user_postalcode);
            $request->session()->put('user_mobile', $userObject->user_mobile);
            $request->session()->put('user_city', $userObject->user_city);
            $request->session()->put('user_address', $userObject->user_address);
            $request->session()->put('user_image', $userObject->user_image);
            $request->session()->put('user_type', $userObject->user_type);
            if($userObject->user_type == 3){
                return redirect()->route("discounterRoute")->with('successInsert',true);
            }
            if($request->input("access") == 'basket')
            {
                return redirect()->route("shippingRoute")->with('successInsert',true);
            }
            if($request->input("access") == 'reward')
            {
                $id_reward = $request->input("id_reward");
                return redirect()->route("singleRewardRoute",['id'=>$id_reward])->with('successInsert',true);
            }
            if($request->input("access") == 'quiz')
            {
                return redirect()->route("QuizCodeRoute");
            }
            return redirect()->route("indexRoute")->with('successInsert',true);
        }
        else
        {
            return redirect()->back()->with('noUserFound',true);
        }
    }

    /**
     * @param $book_id
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function doFastLogin($book_id,Request $request)
    {

        $this->validate(request(), [
            'username_login' => 'required',
            'password_login' => 'required',
            'captcha_login' => 'required|captcha',
        ], [
            'username_login.required' => '* لطفا نام کاربری را وارد کنید',
            'password_login.required' => '* لطفا رمز عبور را وارد کنید',
            'captcha_login.required'=>'* لطفا کد امنیتی را وارد کنید',
            'captcha_login.captcha'=>'* کد امنیتی اشتباه است',
        ]);
        $password= $request->input("password_login")."ascvrtye43";
        $userObject =UserModel::where("user_name","=",$request->input("username_login"))->where("user_password","=",md5($password))->first();
        if($userObject instanceof  UserModel)
        {
            $request->session()->put('username', $userObject->user_name);
            $request->session()->put('user_id', $userObject->user_id);
            $request->session()->put('user_flname', $userObject->user_flname);
            $request->session()->put('user_coin', $userObject->user_coin);
            $request->session()->put('user_postalcode', $userObject->user_postalcode);
            $request->session()->put('user_mobile', $userObject->user_mobile);
            $request->session()->put('user_city', $userObject->user_city);
            $request->session()->put('user_address', $userObject->user_address);
            $request->session()->put('user_image', $userObject->user_image);
            return redirect()->route("checkoutRoute",["book_id"=>$book_id])->with('successLogin',true);
        }
        else
        {
            return redirect()->back()->with('loginError',true);
        }
    }
 public function doFastLoginReward($reward_id,Request $request)
    {

        $this->validate(request(), [
            'username_login' => 'required',
            'password_login' => 'required',
            'captcha_login' => 'required|captcha',
        ], [
            'username_login.required' => '* لطفا نام کاربری را وارد کنید',
            'password_login.required' => '* لطفا رمز عبور را وارد کنید',
            'captcha_login.required'=>'* لطفا کد امنیتی را وارد کنید',
            'captcha_login.captcha'=>'* کد امنیتی اشتباه است',
        ]);


        $password= $request->input("password_login")."ascvrtye43";
        $userObject =UserModel::where("user_name","=",$request->input("username_login"))->where("user_password","=",md5($password))->first();
        if($userObject instanceof  UserModel)
        {
            $request->session()->put('username', $userObject->user_name);
            $request->session()->put('user_id', $userObject->user_id);
            $request->session()->put('user_flname', $userObject->user_flname);
            $request->session()->put('user_coin', $userObject->user_coin);
            $request->session()->put('user_postalcode', $userObject->user_postalcode);
            $request->session()->put('user_mobile', $userObject->user_mobile);
            $request->session()->put('user_city', $userObject->user_city);
            $request->session()->put('user_address', $userObject->user_address);
            $request->session()->put('user_image', $userObject->user_image);
            return redirect()->route("singleRewardRoute",["id"=>$reward_id])->with('successLogin',true);
        }
        else
        {
            return redirect()->back()->with('loginError',true);
        }
    }
    public function doFastLoginQuiz(Request $request)
    {

      $this->validate(request(), [
            'username_login' => 'required',
            'password_login' => 'required',
            'captcha_login_quiz' => 'required|captcha',
        ], [
            'username_login.required' => '* لطفا نام کاربری را وارد کنید',
            'password_login.required' => '* لطفا رمز عبور را وارد کنید',
            'captcha_login_quiz.required'=>'* لطفا کد امنیتی را وارد کنید',
            'captcha_login_quiz.captcha'=>'* ......کد امنیتی اشتباه است',
        ]);


        $password= $request->input("password_login")."ascvrtye43";
        $userObject =UserModel::where("user_name","=",$request->input("username_login"))->where("user_password","=",md5($password))->first();
        if($userObject instanceof  UserModel)
        {
            $request->session()->put('username', $userObject->user_name);
            $request->session()->put('user_id', $userObject->user_id);
            $request->session()->put('user_flname', $userObject->user_flname);
            $request->session()->put('user_coin', $userObject->user_coin);
            $request->session()->put('user_postalcode', $userObject->user_postalcode);
            $request->session()->put('user_mobile', $userObject->user_mobile);
            $request->session()->put('user_city', $userObject->user_city);
            $request->session()->put('user_address', $userObject->user_address);
            $request->session()->put('user_image', $userObject->user_image);
            return redirect()->route("QuizCodeRoute")->with('successLogin',true);
        }
        else
        {
            return redirect()->back()->with('loginError',true);
        }
    }
    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function doFastRegister(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'username' => 'required|unique:tbl_users,user_name',
            'password' => 'required|confirmed|min:6',
            'captcha' => 'required|captcha',
        ], [
            'username.required' => '* لطفا نام کاربری را وارد کنید',
            'username.unique' => '* نام کاربری تکراری است',
            'password.required' => '* لطفا رمز عبور را وارد کنید',
            'password.confirmed' => '* رمزهای عبور مطابقت ندارند',
            'password.min' => '* رمز عبور حداقل باید حاوی ۶ کاراکتر باشد',
            'captcha.required' => '* لطفا کد امنیتی را وارد کنید',
            'captcha.captcha' => '* کد امنیتی اشتباه است',
        ]);
        $password= $request->input("password")."ascvrtye43";
        $newPassword = md5($password);
        $userRecord = [
            'user_flname'=>$request->input("name"),
            'user_name'=>$request->input("username"),
            'user_password'=>$newPassword,
        ];
        $userObj = UserModel::create($userRecord);
        if($userObj instanceof UserModel)
        {
            $request->session()->put('username', $userObj->user_name);
            $request->session()->put('user_id', $userObj->user_id);
            $request->session()->put('user_flname', $userObj->user_flname);
            $request->session()->put('user_coin', $userObj->user_coin);
            $request->session()->put('user_postalcode', $userObj->user_postalcode);
            $request->session()->put('user_mobile', $userObj->user_mobile);
            $request->session()->put('user_city', $userObj->user_city);
            $request->session()->put('user_address', $userObj->user_address);
            $request->session()->put('user_image', $userObj->user_image);
            return redirect()->route("userDashboardRoute")->with('successLogin',true);
        }
    }
    public function logout(Request $request)
    {
        $request->session()->forget("username");
        $request->session()->forget("user_id");
        $request->session()->forget("user_flname");
        $request->session()->forget("user_coin");
        $request->session()->forget("user_postalcode");
        $request->session()->forget("user_mobile");
        $request->session()->forget("user_address");
        $request->session()->forget("user_city");
        $request->session()->forget("user_image");
        return redirect()->route("indexRoute");
    }

    public function retrievePassword()
    {
        return view("Front.Login.Retrieve");
    }

    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postRetrievePassword(Request $request)
    {
        $this->validate(request(),[
            'mobile'=>'required',
            'captcha'=>'required|captcha',

        ],[
            'mobile.required'=>'* لطفا تلفن همراه خود را وارد کنید',
            'captcha.required'=>'* لطفا کد امنیتی را وارد کنید',
            'captcha.captcha'=>'* کد امنیتی اشتباه است',
        ]);
        $mobile =$request->input("mobile");
        $verify_code = random_int(12345678,87654321);
        //Smsirlaravel::sendVerification($verify_code,$mobile);
        $this->sendPatternSms($mobile,$verify_code);
        session()->put("verify_new_password",$verify_code);
        session()->put("verify_mobile",$mobile);
        return redirect()->route("confirmPasswordRoute");
    }

    public function sendPatternSms($mobile,$verify_code)
    {
        $client = new Client("PFJE-6LtIYKrSfbN-48m0dpLog7n9UUr5zXsi94vkn4=");
        try {
            $pattern = $client->sendPattern("lnt7trobo0", "+983000505", (string)$mobile, ['code' => (string)$verify_code]);
        } catch (Error $e) {
            var_dump($e->unwrap());
            echo $e->getCode();
            if ($e->code() == ResponseCodes::ErrUnprocessableEntity) {
                echo "Unprocessable entity";
            }
        } catch (HttpException $e) {
            var_dump($e->getMessage());
            echo $e->getCode();
        }
    }

    public function confirm_password(Request $request)
    {
        $mobile = session()->get("verify_mobile");
        if(!empty($mobile))
        {
            return view("Front.Login.Confirm");
        }
        else
        {
            return redirect()->route("userLoginRoute");
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function post_confirm_password(Request $request)
    {
        $this->validate(request(),[
            'code'=>'required',
        ],[
            'code.required'=>'* لطفا رمز عبور جدید را وارد کنید',
        ]);
        if(session()->get("verify_new_password")==$request->input("code"))
        {
            $userObj = UserModel::where("user_mobile",session()->get("verify_mobile"))->first();
            $password= $request->input("code")."ascvrtye43";
            $newPassword = md5($password);
            UserModel::where('user_mobile', session()->get("verify_mobile"))
                ->update(array('user_password' => $newPassword));
            if($userObj->user_name){
                $request->session()->put('username', $userObj->user_name);
            }
            $request->session()->put('user_id', $userObj->user_id);
            $request->session()->put('user_flname', $userObj->user_flname);
            $request->session()->put('user_coin', $userObj->user_coin);
            $request->session()->put('user_postalcode', $userObj->user_postalcode);
            $request->session()->put('user_mobile', $userObj->user_mobile);
            $request->session()->put('user_city', $userObj->user_city);
            $request->session()->put('user_address', $userObj->user_address);
            $request->session()->put('user_image', $userObj->user_image);
            session()->forget("verify_new_password");
            session()->forget("verify_mobile");
            return redirect()->route("userDashboardRoute")->with('successLogin',true);
        }
        else
        {
            return redirect()->route("confirmPasswordRoute")->with("wrong_code",true);
        }
    }

    public function AdminLogin()
    {
        return view("Front.Login.AdminLogin");
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function PostAdminLogin(Request $request)
    {
        $this->validate(request(),[
            'username'=>'required',
            'password'=>'required',
            'captcha'=>'required|captcha',
        ],[
            'username.required'=>'* لطفا نام کاربری را وارد کنید',
            'password.required'=>'* لطفا رمز عبور را وارد کنید',
            'captcha.required'=>'* لطفا کد امنیتی را وارد کنید',
            'captcha.captcha'=>'* کد امنیتی وارد شده صحیح نیست',
        ]);
        $password= $request->input("password")."ascvrtye43";
        $adminObject =UserModel::where("user_name","=",$request->input("username"))->where("user_password","=",md5($password))->where("user_type","=",2)->first();
        if($adminObject instanceof  UserModel)
        {

            $request->session()->put('admin_username', $adminObject->user_name);
            $request->session()->put('admin_user_id', $adminObject->user_id);
            $request->session()->put('admin_user_flname', $adminObject->user_flname);
            $request->session()->put('admin_user_mobile', $adminObject->user_mobile);
            return redirect()->route("adminDashboardRoute")->with('successLogin',true);
        }
    }

    public function about(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $activeMenu = "about";
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        return view("Front.About.Index",compact("activeMenu","cats","catRewards",'user_state'));
    }

    public function contact(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        return view("Front.Contact.Index",compact('user_state','catRewards','cats'));
    }

    public function postContact(Request $request)
    {
        $this->validate(request(), [
            'flname' => 'required',
            'subject' => 'required|not_in:0',
            'tell' => 'required',
            'message' => 'required',
            'captcha' => 'required|captcha',
        ], [
            'flname.required' => '* لطفا نام و نام خانوادگی را وارد کنید',
            'subject.required' => '* لطفا موضوع را وارد کنید',
            'subject.not_in' => '* لطفا موضوع را وارد کنید',
            'tell.required' => '* لطفا تلفن همراه را وارد کنید',
            'message.required' => '* لطفا متن پیام را وارد کنید',
            'captcha.required' => '* لطفا کد امنیتی را وارد کنید',
            'captcha.captcha' => '* کد امنیتی اشتباه است',
        ]);
        $message = $request->input("message");
        $subject = $request->input("subject");
        $flname = $request->input("flname");
        $tell = $request->input("tell");
        $messageData =[
            'message_name'=>$flname,
            'message_subject'=>$subject,
            'message_tell'=>$tell,
            'message_text'=>$message,
        ];
        $messageObj =MessageModel::create($messageData);
        if($messageObj instanceof MessageModel)
        {
            return redirect()->back()->with("successInsert",true);
        }

    }
    public function quizCode(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        if ($user_state == "logined"){
            $cats=BookCatModel::all();
            $catRewards = RewardCatModel::all();
            $activeMenu = "quizs";
            return view('User.Quiz.Index',compact("activeMenu",'user_state','cats','catRewards'));
        }
        else{
            return redirect()->route("userLoginRoute",['type'=>'quiz','id'=>'0']);
        }
    }
    public function blog(Request $request)
    {
        $blogs = DB::table('tbl_posts')
            ->join('tbl_post_category','tbl_post_category.category_id','=','tbl_posts.category_id')
            ->select('tbl_posts.status as status','tbl_posts.id as id','tbl_posts.slug as slug','tbl_posts.title as title','tbl_posts.media as media','tbl_posts.created_at as date','tbl_post_category.category_name as category')
            ->orderByDesc('id')
            ->paginate(12);
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $activeMenu = "blog";
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        $catBlogs = CategoryPostModel::all();
        return view('Front.Blog.Index',compact("blogs","catRewards",'catBlogs',"cats","activeMenu",'user_state'));
    }
    public function single_blog($slug = false,Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $activeMenu = "single_blog";
     
            $cats=BookCatModel::all();
            $catRewards = RewardCatModel::all();
            $blog = DB::table('tbl_posts')
                ->join('tbl_post_category','tbl_post_category.category_id','=','tbl_posts.category_id')
                ->select('tbl_posts.status as status','tbl_posts.slug as slug','tbl_posts.id as id',
                    'tbl_posts.title as title','tbl_posts.media as media',
                    'tbl_posts.description',
                    'tbl_posts.category_id',
                    'tbl_posts.created_at',
                    'tbl_posts.created_at as date','tbl_post_category.category_name as category')
                ->where('tbl_posts.slug',$slug)
                ->first();
                $id = $blog->id;
            $comments = DB::table('tbl_posts')
                ->join('tbl_comments','tbl_posts.id','=','tbl_comments.foreign_id')
                ->leftJoin('tbl_users','tbl_users.user_id','=','tbl_comments.user_id')
                ->select('tbl_users.user_flname',
                    'tbl_comments.text',
                    'tbl_comments.created_at')
                ->where('tbl_comments.type',1)
                ->where('tbl_comments.foreign_id',$id)
                ->where('tbl_comments.status',1)
                ->paginate(10);

            $blog_related = PostModel::where('category_id',$blog->category_id)->orderby("category_id", "DESC")->paginate(12);
            if($blog != null)
            {
                return view('Front.Blog.Single',compact("blog",'cats','user_state','comments'
                    ,'catRewards','blog_related',"activeMenu"));
            }

    }

    public function insert_comment_book(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $this->validate(request(),[
            'text'=>'required',
            'captcha' => 'required|captcha',
        ],[
            'text.required'=>'* متن نظر را وارد کنید',
            'captcha.required' => '* لطفا کد امنیتی را وارد کنید',
            'captcha.captcha' => '* کد امنیتی اشتباه است',
        ]);
        if ($user_state == "logined"){
            $commentRecord = [
                'foreign_id'=>$request->input('book_id'),
                'type'=>2,
                'text'=>$request->input('text'),
                'user_id'=>$user_id,
            ];
        }
        else{
            $commentRecord = [
                'foreign_id'=>$request->input('book_id'),
                'type'=>2,
                'text'=>$request->input('text'),
            ];
        }
        $commentObj = CommentModel::create($commentRecord);
        if($commentObj instanceof CommentModel)
        {
            //return redirect()->back()->with("successInsert",true);
            return response()->json(['state' => "successInsert"]);
        }
    }
    public function insert_comment_reward(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $this->validate(request(),[
            'text'=>'required',
            'captcha' => 'required|captcha',
        ],[
            'text.required'=>'* متن نظر را وارد کنید',
            'captcha.required' => '* لطفا کد امنیتی را وارد کنید',
            'captcha.captcha' => '* کد امنیتی اشتباه است',
        ]);
        if ($user_state == "logined"){
            $commentRecord = [
                'foreign_id'=>$request->input('reward_id'),
                'type'=>3,
                'text'=>$request->input('text'),
                'user_id'=>$user_id,
            ];
        }
        else{
            $commentRecord = [
                'foreign_id'=>$request->input('reward_id'),
                'type'=>3,
                'text'=>$request->input('text'),
            ];
        }
        $commentObj = CommentModel::create($commentRecord);
        if($commentObj instanceof CommentModel)
        {
            //return redirect()->back()->with("successInsert",true);
            return response()->json(['state' => "successInsert"]);
        }
    }
    public function insert_comment_blog(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("blog_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $this->validate(request(),[
            'text'=>'required',
            'captcha' => 'required|captcha',
        ],[
            'text.required'=>'* متن نظر را وارد کنید',
            'captcha.required' => '* لطفا کد امنیتی را وارد کنید',
            'captcha.captcha' => '* کد امنیتی اشتباه است',
        ]);
        if ($user_state == "logined"){
            $commentRecord = [
                'foreign_id'=>$request->input('blog_id'),
                'type'=>1,
                'text'=>$request->input('text'),
                'user_id'=>$user_id,
            ];
        }
        else{
            $commentRecord = [
                'foreign_id'=>$request->input('blog_id'),
                'type'=>1,
                'text'=>$request->input('text'),
            ];
        }
        $commentObj = CommentModel::create($commentRecord);
        if($commentObj instanceof CommentModel)
        {
            //return redirect()->back()->with("successInsert",true);
            return response()->json(['state' => "successInsert"]);
        }
    }
    public function searchBlogByName(Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $activeMenu = "reward";
        $text = $_GET['search_name_blog'];
        $catBlogs = CategoryPostModel::all();
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        $blogs = DB::table('tbl_posts')
            ->join('tbl_post_category','tbl_post_category.category_id','=','tbl_posts.category_id')
            ->select('tbl_posts.status as status','tbl_posts.id as id','tbl_posts.title as title','tbl_posts.media as media','tbl_posts.created_at as date','tbl_post_category.category_name as category')
            ->orderByDesc('id')
            ->Where('title', 'like', '%' . $text . '%')
            ->Where('description', 'like', '%' . $text . '%')
            ->orderBy("id","DESC")->paginate(12);
        $blogs->appends(['search_name_blog' => $text ]);
        return view('Front.Blog.Index',compact("blogs",'user_state','cats',
            "catRewards","activeMenu","catBlogs"));
    }
    public function ajax_cat_blog($cat_id=false)
    {
        $blogs = DB::table('tbl_posts')
            ->join('tbl_post_category','tbl_post_category.category_id','=','tbl_posts.category_id')
            ->select('tbl_posts.status as status','tbl_posts.id as id','tbl_posts.title as title','tbl_posts.media as media','tbl_posts.created_at as date','tbl_post_category.category_name as category')
            ->orderByDesc('id')
            ->where('tbl_posts.category_id',$cat_id)
            ->paginate(12);
        if ($cat_id=="all"){
            $blogs = DB::table('tbl_posts')
                ->join('tbl_post_category','tbl_post_category.category_id','=','tbl_posts.category_id')
                ->select('tbl_posts.status as status','tbl_posts.id as id','tbl_posts.title as title','tbl_posts.media as media','tbl_posts.created_at as date','tbl_post_category.category_name as category')
                ->orderByDesc('id')
                ->paginate(12);
        }
        $catBlogs = CategoryPostModel::all();
        return view('Front.Blog.ajax', compact('blogs','catBlogs'))->render();
    }
    public function cat_blog($cat_id=false,Request $request)
    {
        $user_state ="";
        $user_id = $request->session()->get("user_id");
        if($user_id!=null) {
            $user_state ="logined";
        }
        $activeMenu = "shop";
        $sliders = ShopSliderModel::all();
        $cats=BookCatModel::all();
        $catBlogs = CategoryPostModel::all();
        $catRewards = RewardCatModel::all();
        $blogs = DB::table('tbl_posts')
            ->join('tbl_post_category','tbl_post_category.category_id','=','tbl_posts.category_id')
            ->select('tbl_posts.status as status','tbl_posts.id as id','tbl_posts.title as title','tbl_posts.media as media','tbl_posts.created_at as date','tbl_post_category.category_name as category')
            ->orderByDesc('id')
            ->where('tbl_posts.category_id',$cat_id)
            ->paginate(12);
        return view('Front.Blog.Index',compact('cats','blogs','user_state','catBlogs',
            "sliders","activeMenu","catRewards"));
    }
}
