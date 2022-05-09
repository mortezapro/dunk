<?php

namespace App\Http\Controllers\Admin;
use App\Models\CategoryPostModel;
use App\Models\CommentModel;
use App\Models\ContactUsModel;
use App\Models\JoinCatBook;
use App\Models\DiscountModel;
use App\Models\OrderModel;
use App\Models\PostModel;
use App\Models\RewardcatModel;
use App\Models\RewardModel;
use App\Models\ShopSliderModel;
use App\models\UserModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\BookCatModel;
use App\Models\RequestRewardModel;
use App\Models\BookModel;
use App\Models\CodesModel;
use App\Models\QuestionModel;
use App\Models\QuizModel;
use App\Models\SettingModel;
use App\Models\RequestmoneyModel;
use App\Models\SliderModel;
use App\Models\MessageModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware("VerifyAdmin");
        $this->middleware("ValidateBack");
    }
    /* orders */
    public function dashboard()
    {
        $weekDate = Carbon::today()->subDays(7);
        $monthDate = Carbon::today()->subDays(30);
        $yearDate = Carbon::today()->subDays(365);
        $monthPrice= OrderModel::where("ref_id","<>",'0')->where('updated_at', '>=', $monthDate)->sum("price");
        $weekPrice= OrderModel::where("ref_id","<>",'0')->where('updated_at', '>=', $weekDate)->sum("price");
        $yearPrice= OrderModel::where("ref_id","<>",'0')->where('updated_at', '>=', $yearDate)->sum("price");
        $monthRecordSuccess = OrderModel::where("ref_id","<>",'0')->where('updated_at', '>=', $monthDate)->with("book")->with("users")->orderby("updated_at","desc")->paginate(10);
        $weekRecordSuccess = OrderModel::where("ref_id","<>",'0')->where('updated_at', '>=', $weekDate)->with("book")->with("users")->orderby("updated_at","desc")->paginate(10);
        $yearRecordSuccess = OrderModel::where("ref_id","<>",'0')->where('updated_at', '>=', $yearDate)->with("book")->with("users")->orderby("updated_at","desc")->paginate(10);
        return view("Dashboard.Index.Index",compact("monthPrice","weekPrice","yearPrice","monthRecordSuccess","weekRecordSuccess","yearRecordSuccess"));
    }
    public function report(){
        return view("Dashboard.Report.index");
    }
    public function postReport(Request $request){
        $fromDate = $request->input("fromDate");
        $fromDate = self::convert($fromDate);
        $fromDate = explode("/",$fromDate);
        $fromDate = (new Jalalian($fromDate[0],$fromDate[1],$fromDate[2]))->toCarbon()->toDateTimeString();

        $toDate = $request->input("toDate");
        $toDate = self::convert($toDate);
        $toDate = explode("/",$toDate);
        $toDate = (new Jalalian($toDate[0],$toDate[1],$toDate[2]))->toCarbon()->toDateTimeString();

        $orders = OrderModel::where("ref_id","<>",'0')->where('updated_at', '>=',$fromDate)->where('updated_at', '<=',$toDate)->with("book")->with("users")->orderby("updated_at","desc")->get();
        return view("Dashboard.Report.index",compact("orders"));
    }


    public static function convert($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);
        return $englishNumbersOnly;
    }
    public function orders(Request $request)
    {
//        if($order_state!=false){
//            $orders = DB::table("tbl_orders")->where("order_state","=",'2')->join("tbl_users","tbl_users.user_id","=","tbl_orders.user_id")->join("tbl_books","tbl_books.book_id","=","tbl_orders.book_id")->orderby("order_id","desc")->paginate("8");
//
//        }
//        else
//            $orders = DB::table("tbl_orders")->where("order_state","=",'1')->where("ref_id","<>",'0')->join("tbl_users","tbl_users.user_id","=","tbl_orders.user_id")->get;

        if ($request->ajax()) {
            $data = DB::table("tbl_orders")
                // ->where("order_state","=",'1')
                // ->where("ref_id","<>",'0')
                // ->select('tbl_users.user_flname','tbl_orders.*')
                ->Leftjoin("tbl_users","tbl_users.user_id","=","tbl_orders.user_id")
                ->orderByDesc('order_id')
                ->get();

            // dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<a href="'.route("editOrderRoute",['id'=>$row->order_id]).'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">مشاهده</a>';
                    return $action;

                })
                ->rawColumns(['action'])
                ->editColumn('order_state', function ($data) {
                    if($data->order_state == "0")
                    {
                        return "سفارش جدید";
                    }
                    if($data->order_state == "1")
                    {
                        return "ارسال شده";
                    }
                    if($data->order_state == "2")
                    {
                        return "آماده برای ارسال";
                    }
                })
                ->editColumn('payment_status', function ($data) {
                    if($data->ref_id != "0")
                    {
                        return "پرداخت شده";
                    }
                    if($data->ref_id == "0")
                    {
                        return "عدم پرداخت";
                    }
                })
                ->make(true);
        }


        return view("Dashboard.Orders.index");

        // return view("Dashboard.Orders.index",compact("orders"));
    }
    public function delete_order($order_id=false)
    {
        if(ctype_digit($order_id))
        {
            $deleteorder = OrderModel::find($order_id);
            if($deleteorder instanceof OrderModel)
            {
                QuestionModel::destroy($order_id);
                return redirect()->back()->with('successDelete',true);
            }
        }
    }
    public function edit_order($order_id=false)
    {
        // $order = OrderModel::where("order_id","=",$order_id)->first();
        $order = DB::table('tbl_orders as o')
            ->join('tbl_price_post as p','p.id',"=",'o.city')
            ->where('o.order_id',$order_id)
            ->first();
        // dd($order);
        $books = DB::table('tbl_orders as o')
            ->select('o.total_price','b.motarjem','b.nasher','b.book_name','b.nevisande','b.coin','b.book_name','ci.quantity','p.city as city')
            ->join('tbl_shopping_cart as sc','sc.id',"=",'o.shopping_cart_id')
            ->join('tbl_cart_items as ci','ci.shopping_cart_id',"=",'sc.id')
            ->join('tbl_books as b','b.book_id',"=",'ci.product_id')
            ->join('tbl_price_post as p','p.id',"=",'o.city')
            ->where('o.order_id',$order_id)->get();
        $user = UserModel::where("user_id","=",$order->user_id)->first();

        return view("Dashboard.Orders.edit",compact("order","books","user"));
    }

    public function update_order(Request $request,$order_id=false)
    {
      //  dd($order_id);

        if(ctype_digit($order_id))
        {

            $order_item = OrderModel::find($order_id);

            if($order_item instanceof OrderModel)
            {
                $orderRecord = [
                    "order_state"=>2,
                ];
                $order_item->update($orderRecord);
                return redirect()->back()->with('successChangeState',true);
            }
        }
    }
    /* end orders */


    /*category route*/
    public function category()
    {
        $categories = BookCatModel::paginate(10);
        // dd($categories);
        return view("Dashboard.Category.index",compact("categories"));
    }
    public function add_category()
    {
        return view("Dashboard.Category.add");
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert_category(Request $request)
    {
        $this->validate(request(),[
            'category'=>'required',
        ],[
            'category.required'=>'* لطفا نام دسته را وارد کنید',
        ]);
        $categoryRecord = [
            'category_name'=>$request->input("category"),
        ];
        $categoryObj = BookCatModel::create($categoryRecord);
        if($categoryObj instanceof BookCatModel)
        {
            return redirect()->route("categoryRoute")->with('successInsert',true);
        }
    }
    public function edit_category($category_id=false)
    {
        $category = BookCatModel::where("category_id","=",$category_id)->first();
        return view("Dashboard.Category.edit",compact("category"));
    }
    /**
     * @param Request $request
     * @param bool $category_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update_category(Request $request, $category_id=false)
    {
        $this->validate(request(),[
            'category'=>'required',
        ],[
            'category.required'=>'* لطفا نام دسته را وارد کنید',
        ]);
        if(ctype_digit($category_id))
        {
            $category_item = BookCatModel::find($category_id);
            if($category_item instanceof BookCatModel)
            {
                $categoryRecord = [
                    "category_name"=>$request->input("category"),
                ];
                $category_item->update($categoryRecord);
                return redirect()->route("categoryRoute")->with('successEdit',true);
            }
        }
    }
    public function delete_category($category_id=false)
    {
        if(ctype_digit($category_id))
        {
            $deleteCategory = BookCatModel::find($category_id);
            if($deleteCategory instanceof BookCatModel)
            {
                BookCatModel::destroy($category_id);
                return redirect()->back()->with('successDelete',true);
            }
        }
    }
    /*end category*/

    /*Quiz Route*/
    public function quiz(Request $request)
    {
        // $quizs = QuizModel::inRandomOrder()->get()->take(3);
        //$quizs = QuizModel::orderByDesc('quiz_id')->paginate(20);
        //return view("Dashboard.Quiz.index",compact("quizs"));
        if ($request->ajax()) {
            $data = DB::table("tbl_quiz")
                ->orderBy('quiz_id','desc')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<a href="'.route("editQuizRoute",['id'=>$row->quiz_id]).'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">ویرایش</a>
                    <a href="'.route("deleteQuizRoute",['id'=>$row->quiz_id]).'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-danger btn-sm editProduct">حذف</a>'
                    ;
                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("Dashboard.Quiz.index");
    }
    public function add_quiz()
    {
        return view("Dashboard.Quiz.add");
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert_quiz(Request $request)
    {
        $this->validate(request(),[
            'quiz_name'=>'required',
            'quiz_time'=>'required',
            'quiz_score'=>'required',
            'quiz_count'=>'required',
        ],[
            'quiz_name.required'=>'* لطفا نام آزمون را وارد کنید',
            'quiz_time.required'=>'* لطفا زمان آزمون را وارد کنید',
            'quiz_score.required'=>'* لطفا امتیاز آزمون را وارد کنید',
            'quiz_count.required'=>'* لطفا تعداد سوالات را وارد کنید',
        ]);
        $quizRecord = [
            'quiz_name'=>$request->input("quiz_name"),
            'quiz_time'=>$request->input("quiz_time"),
            'quiz_count'=>$request->input("quiz_count"),
            'quiz_score'=>$request->input("quiz_score"),
        ];
        $QuizObj = QuizModel::create($quizRecord);
        if($QuizObj instanceof QuizModel)
        {
            return redirect()->route("quizRoute")->with('successInsert',true);
        }
    }
    public function edit_quiz($quiz_id=false)
    {
        $quiz =QuizModel::where("quiz_id","=",$quiz_id)->first();
        return view("Dashboard.Quiz.edit",compact("quiz"));
    }
    /**
     * @param Request $request
     * @param bool $quiz_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update_quiz(Request $request, $quiz_id=false)
    {
        $this->validate(request(),[
            'quiz_name'=>'required',
            'quiz_time'=>'required',
            'quiz_score'=>'required',
            'quiz_count'=>'required',
        ],[
            'quiz_name.required'=>'* لطفا نام آزمون را وارد کنید',
            'quiz_time.required'=>'* لطفا زمان آزمون را وارد کنید',
            'quiz_score.required'=>'* لطفا امتیاز آزمون را وارد کنید',
            'quiz_count.required'=>'* لطفا تعداد سوالات را وارد کنید',
        ]);
        if(ctype_digit($quiz_id))
        {

            $quiz_item = QuizModel::find($quiz_id);

            if($quiz_item instanceof QuizModel)
            {
                $quizRecord = [
                    'quiz_name'=>$request->input("quiz_name"),
                    'quiz_time'=>$request->input("quiz_time"),
                    'quiz_count'=>$request->input("quiz_count"),
                    'quiz_score'=>$request->input("quiz_score"),
                ];
                $quiz_item->update($quizRecord);
                return redirect()->route("quizRoute")->with('successEdit',true);
            }
        }
    }
    public function delete_quiz($quiz_id=false)
    {
        if(ctype_digit($quiz_id))
        {
            $deletequiz = QuizModel::find($quiz_id);
            if($deletequiz instanceof QuizModel)
            {
                QuizModel::destroy($quiz_id);
                return redirect()->back()->with('successDelete',true);
            }
        }
    }
    /* end Quiz Route*/

    /*question Route*/
    public function add_question()
    {
        $quizs = QuizModel::all();
        return view("Dashboard.Question.add",compact("quizs"));
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert_question(Request $request)
    {

        $this->validate(request(),[
            'question_text'=>'required',
            'gozineh1'=>'required',
            'gozineh2'=>'required',
            'gozineh3'=>'required',
            'gozineh4'=>'required',
            'question_answer'=>'required',
        ],[
            'question_text'=>'* لطفا متن سوال را وارد کنید',
            'gozineh1.required'=>'* لطفا گزینه ی 1 را وارد کنید',
            'gozineh2.required'=>'* لطفا گزینه ی 2 را وارد کنید',
            'gozineh3.required'=>'* لطفا گزینه ی 3 را وارد کنید',
            'gozineh4.required'=>'* لطفا گزینه ی 4 را وارد کنید',
            'question_answer'=>'* لطفا پاسخ را وارد کنید',
        ]);
        $quiz_id =$request->input("quiz_id");
        $question_text =$request->input("question_text");
        $gozineh1 =$request->input("gozineh1");
        $gozineh2 =$request->input("gozineh2");
        $gozineh3 =$request->input("gozineh3");
        $gozineh4 =$request->input("gozineh4");
        $question_answer =$request->input("question_answer");
        $question_record = [
            "quiz_id"=>$quiz_id,
            "question_text"=>$question_text,
            "gozineh1"=>$gozineh1,
            "gozineh2"=>$gozineh2,
            "gozineh3"=>$gozineh3,
            "gozineh4"=>$gozineh4,
            "question_answer"=>$question_answer,
        ];
        $questionObj = QuestionModel::create($question_record);
        if($questionObj instanceof QuestionModel)
        {
            // return redirect()->route("questionRoute")->with('successInsert',true);
            //return back()->withInput();
            return redirect()->back()->with(['successInsert'=>true,'quiz_id'=>$quiz_id]);
        }
    }
    public function question(Request $request)
    {
              //      $data = DB::table("tbl_question")->join("tbl_quiz","tbl_question.quiz_id","=","tbl_quiz.quiz_id")->orderBy('question_id','desc')->get();
//dd($data);
        if ($request->ajax()) {
            $data = DB::table("tbl_question")->join("tbl_quiz","tbl_question.quiz_id","=","tbl_quiz.quiz_id")->orderBy('question_id','desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<a href="'.route("editQuestionRoute",['id'=>$row->question_id]).'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">ویرایش</a>
                    <a href="'.route("deleteQuestionRoute",['id'=>$row->question_id]).'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-danger btn-sm editProduct">حذف</a>'
                    ;
                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("Dashboard.Question.index");
    }
    public function delete_question($question_id=false)
    {
        if(ctype_digit($question_id))
        {
            $deletequestion = QuestionModel::find($question_id);
            if($deletequestion instanceof QuestionModel)
            {
                QuestionModel::destroy($question_id);
                return redirect()->back()->with('successDelete',true);
            }
        }
    }
    public function edit_question($question_id=false)
    {
        $quizs = QuizModel::all();
        $questions = DB::table("tbl_question")->where("question_id","=",$question_id)->join("tbl_quiz","tbl_question.quiz_id","=","tbl_quiz.quiz_id")->first();
        return view("Dashboard.Question.edit",compact("questions","quizs"));
    }
    /**
     * @param Request $request
     * @param bool $question_id
     * @return bool|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update_question(Request $request, $question_id=false)
    {
        $this->validate(request(),[
            'question_text'=>'required',
            'gozineh1'=>'required',
            'gozineh2'=>'required',
            'gozineh3'=>'required',
            'gozineh4'=>'required',
            'question_answer'=>'required',
        ],[
            'question_text'=>'* لطفا متن سوال را وارد کنید',
            'gozineh1.required'=>'* لطفا گزینه ی 1 را وارد کنید',
            'gozineh2.required'=>'* لطفا گزینه ی 2 را وارد کنید',
            'gozineh3.required'=>'* لطفا گزینه ی 3 را وارد کنید',
            'gozineh4.required'=>'* لطفا گزینه ی 4 را وارد کنید',
            'question_answer'=>'* لطفا پاسخ را وارد کنید',
        ]);
        if(ctype_digit($question_id))
        {
            $question_item = QuestionModel::find($question_id);
            if($question_item instanceof QuestionModel)
            {
                $quiz_id =$request->input("quiz_id");
                $question_text =$request->input("question_text");
                $gozineh1 =$request->input("gozineh1");
                $gozineh2 =$request->input("gozineh2");
                $gozineh3 =$request->input("gozineh3");
                $gozineh4 =$request->input("gozineh4");
                $question_answer =$request->input("question_answer");
                $question_record = [
                    "quiz_id"=>$quiz_id,
                    "question_text"=>$question_text,
                    "gozineh1"=>$gozineh1,
                    "gozineh2"=>$gozineh2,
                    "gozineh3"=>$gozineh3,
                    "gozineh4"=>$gozineh4,
                    "question_answer"=>$question_answer,
                ];
                $question_item->update($question_record);
                return redirect()->route("questionRoute")->with('successEdit',true);
            }
        }
        else
        {
            return false;
        }
    }
    /*end question*/

    /* COde */
    public function make_code()
    {
        $quiz_id=2;
        $code_text="jm";
        $number=100;
        for($i=0;$i>$number;$i++){
            $random_code = mt_rand("1111",'9999');
            $codeRecord = [
                'code_text'=>$code_text,
                'code_number'=>$random_code.$i,
                'quiz_id'=>$quiz_id,

            ];
            $codeObj = CodesModel::create($codeRecord);
        }


    }
    public function codes()
    {
        $quizs=QuizModel::orderBy('quiz_id','desc')->get();
        $codes =DB::table('tbl_codes')
            ->join('tbl_quiz', 'tbl_codes.quiz_id', '=', 'tbl_quiz.quiz_id')
            ->join('tbl_users', 'tbl_codes.user_id', '=', 'tbl_users.user_id')
            ->select('tbl_codes.code_text','tbl_codes.code_number','tbl_users.user_name','tbl_codes.quiz_state','tbl_quiz.quiz_name')
            ->where('tbl_codes.user_id','<>','9999999999')
            ->orderByDesc('tbl_codes.code_id')
            ->paginate(100);
//        return response()->json($codes);
        return view("Dashboard.Codes.index",compact("codes"),compact("quizs"));

    }
    
        public function codesNew(Request $request)
    {
        $quizs=QuizModel::orderBy('quiz_id','desc')->get();
         if ($request->ajax()) {
        $codes =DB::table('tbl_codes')
            ->join('tbl_quiz', 'tbl_codes.quiz_id', '=', 'tbl_quiz.quiz_id')
            ->join('tbl_users', 'tbl_codes.user_id', '=', 'tbl_users.user_id')
            ->select('tbl_codes.code_id','tbl_codes.code_text','tbl_codes.code_number','tbl_users.user_name','tbl_codes.quiz_state','tbl_quiz.quiz_name')
            ->where('tbl_codes.user_id','<>','9999999999')
            ->orderByDesc('tbl_codes.code_id');
            return Datatables::of($codes)
            ->editColumn('code_number', function ($data) {
                        return $data->code_text.$data->code_number;
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view("Dashboard.Codes.indexNew",compact("quizs"));

    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function print_code(Request $request)
    {
       /* $this->validate(request(),[
            'start_print'=>'required|numeric',
            'end_print'=>'required|numeric',
        ],[
            'start_print'=>'* لطفا ایدی شروع پرینت را وارد نمایید',
            'end_print'=>'* لطفا ایدی پایان پرینت را وارد نمایید *',
        ]);*/
        $start_print=$request->input('start_print');
        $end_print=$request->input('end_print');
        $codes =CodesModel::whereBetween('code_id', [$start_print, $end_print])->get();
        //dd($codes,$start_print,$end_print);
        return view("Dashboard.Codes.print",compact("codes"));

    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert_code(Request $request)
    {
        $this->validate(request(),[
            'code_text'=>'required',
            'code_counter'=>'required|numeric',
        ],[
            'code_text'=>'* لطفا پیشوند کد را وارد نمایید',
            'code_counter.numeric'=>'برای تعداد فقط عدد وارد نمایید',
        ]);

        $quiz_id = $request->input('quiz_id');
        $code_counter = $request->input('code_counter');
        $code_text=$request->input('code_text');
        //
        $old=CodesModel::where('quiz_id',$quiz_id)->where('code_text',$code_text)->orderBy('code_id','desc')->first();
        if(!empty($old))
            $old_number =substr($old->code_number,4);
        else
            $old_number = 0;
        for($i=1;$i<=$code_counter;$i++){
            $random_code = mt_rand("1111",'9999');
            $codeRecord = [
                'code_text'=>$code_text,
                'code_number'=>$random_code.($i+$old_number),
                'quiz_id'=>$quiz_id,

            ];
            $codeObj = CodesModel::create($codeRecord);

        }
        if($codeObj instanceof CodesModel) {
            return redirect()->route("codeRoute")->with('successInsert', true);
        }
    }
    /* End COde */

    /*Book Route*/
    public function add_book()
    {
        $book_cats = BookCatModel::all();
        return view("Dashboard.Book.add",compact("book_cats"));
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert_book(Request $request)
    {
        $this->validate(request(),[

            'anbar'=>'required',
            'price'=>'required|numeric',
            'coin'=>'required|numeric',
        ],[

            'anbar.required'=>'* لطفا وضعیت انبار را وارد کنید',
            'price.required'=>'* لطفا مبلغ کتاب را وارد کنید',
            'coin.required'=>'* لطفا تعداد سکه را وارد کنید',
            'coin.numeric'=>'برای تعداد سکه فقط عدد وارد نمایید',
            'price.numeric'=>'برای مبلغ کتاب فقط عدد وارد نمایید',
        ]);
        //$category_id =$request->input("category_id");
        $about_book =$request->input("about_book");
        $book_name =$request->input("book_name");
        $nevisande =$request->input("nevisande");
        $nasher =$request->input("nasher");
        $nobate_chap =$request->input("nobate_chap");
        $motarjem =$request->input("motarjem");
        $tasvirgar =$request->input("tasvirgar");
        $tarikh_enteshar =$request->input("tarikh_enteshar");
        $anbar =$request->input("anbar");
        $matne_ketab =$request->input("matne_ketab");
        $price =$request->input("price");
        $coin =$request->input("coin");
        $categorys = request()->input('cat_ids');
        $book_record = [
            'about_book'=>$about_book,
            'book_name'=>$book_name,
            'nevisande'=>$nevisande,
            'nasher'=>$nasher,
            'nobate_chap'=>$nobate_chap,
            'motarjem'=>$motarjem,
            'tasvirgar'=>$tasvirgar,
            'tarikh_enteshar'=>$tarikh_enteshar,
            'anbar'=>$anbar,
            'matne_ketab'=>$matne_ketab,
            'price'=>$price,
            'coin'=>$coin,
        ];
        if($request->file('book_page_image')!= null)
        {
            /*upload book image*/
            $book_page_image= Str::random(45).".".$request->file('book_page_image')->getClientOriginalExtension();
            $request->file('book_page_image')->storeAs('/book_page_image/',$book_page_image);
            $book_record["book_page_image"]=$book_page_image;
        }
        if($request->file('book_image')!= null)
        {
            /*upload book image*/
            $book_image= Str::random(45).".".$request->file('book_image')->getClientOriginalExtension();
            $request->file('book_image')->storeAs('/product/',$book_image);
            $book_record["book_image"]=$book_image;
        }
        $bookObj =BookModel::create($book_record);

        $book = BookModel::orderBy("book_id","desc")->first();
        $book_id = $book->book_id;

        for($j=0;$j<count($categorys);$j++)
        {
            $bookCategories = [
                'category_id'=> $categorys[$j],
                'book_id' =>$book_id,
            ];
            $book_cat = JoinCatBook::create($bookCategories);
        }

        if($bookObj instanceof BookModel)
        {
            return redirect()->route("bookRoute")->with('successInsert',true);
        }

    }
    public function book(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table("tbl_books")->orderBy('book_id','desc')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<a href="'.route("editBookRoute",['id'=>$row->book_id]).'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">ویرایش</a>';
                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("Dashboard.Book.index");
    }
    public function delete_book($book_id=false)
    {
        if(ctype_digit($book_id))
        {
            $deletebook = BookModel::find($book_id);
            DB::table("tbl_book_cat_join")->where("book_id",$book_id)->delete();
            if($deletebook instanceof BookModel)
            {
                BookModel::destroy($book_id);
                return redirect()->back()->with('successDelete',true);
            }
        }
    }
    public function edit_book($book_id=false)
    {
        $cats = BookCatModel::all();
        $book = DB::table("tbl_books")->where("book_id","=",$book_id)->first();
        $book_cats = DB::table('tbl_book_cat_join')->select('category_id')
            ->where('book_id', $book_id)
            ->orderByDesc('id')
            ->get();
        $arr_cat=array();
        foreach($book_cats as $item1)
        {
            array_push($arr_cat,$item1->category_id);
        }


        return view("Dashboard.Book.edit",compact("book","cats","arr_cat"));
    }
    public function update_book(Request $request, $book_id=false)
    {

        if(ctype_digit($book_id))
        {
            $book_item = BookModel::find($book_id);
            if($book_item instanceof BookModel)
            {
                $categorys = request()->input('cat_ids');
                $about_book =$request->input("about_book");
                $book_name =$request->input("book_name");
                $nevisande =$request->input("nevisande");
                $nasher =$request->input("nasher");
                $nobate_chap =$request->input("nobate_chap");
                $motarjem =$request->input("motarjem");
                $tasvirgar =$request->input("tasvirgar");
                $tarikh_enteshar =$request->input("tarikh_enteshar");
                $anbar =$request->input("anbar");
                $matne_ketab =$request->input("matne_ketab");
                $price =$request->input("price");
                $coin =$request->input("coin");
                $book_record = [
                    'about_book'=>$about_book,
                    'book_name'=>$book_name,
                    'nevisande'=>$nevisande,
                    'nasher'=>$nasher,
                    'nobate_chap'=>$nobate_chap,
                    'motarjem'=>$motarjem,
                    'tasvirgar'=>$tasvirgar,
                    'tarikh_enteshar'=>$tarikh_enteshar,
                    'anbar'=>$anbar,
                    'matne_ketab'=>$matne_ketab,
                    'price'=>$price,
                    'coin'=>$coin,
                ];

                if($request->file('book_page_image')!= null)
                {
                    /*delete old image*/
                    @unlink('images/book_page_image/'.$book_item->book_page_image);
                    /*upload new image*/
                    $book_page_image= Str::random(45).".".$request->file('book_page_image')->getClientOriginalExtension();
                    $request->file('book_page_image')->storeAs('/book_page_image/',$book_page_image);
                    $book_record["book_page_image"]=$book_page_image;
                }
                if($request->file('book_image')!= null)
                {
                    /*delete old image*/
                    @unlink('images/product/'.$book_item->book_image);
                    /*upload new image*/
                    $book_image= Str::random(45).".".$request->file('book_image')->getClientOriginalExtension();
                    $request->file('book_image')->storeAs('/product/',$book_image);
                    $book_record["book_image"]=$book_image;
                }
                $book_item->update($book_record);
                DB::table('tbl_book_cat_join')->where('book_id', '=', $book_id)->delete();
                for($j=0;$j<count($categorys);$j++)
                {
                    $bookCategories = [
                        'category_id'=> $categorys[$j],
                        'book_id' =>$book_id,
                    ];
                    $book_cat = JoinCatBook::create($bookCategories);
                }
                return redirect()->route("bookRoute")->with('successEdit',true);
            }
        }
        else
        {
            return false;
        }
    }
    /*end Book*/

    /*slider Route*/
    public function slider()
    {
        $slider = sliderModel::paginate("6");
        return view("Dashboard.Slider.index",compact("slider"));
    }
    public function edit_slider($slider_id=false)
    {
        if(ctype_digit($slider_id))
        {
            $slider = DB::table("tbl_slider")->where("slider_id","=",$slider_id)->first();
            return view("Dashboard.Slider.edit",compact("slider"));
        }
        else
        {
            return false;
        }
    }

    public function add_slider()
    {
        return view("Dashboard.Slider.insert");
    }
    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert_slider(Request $request)
    {
        $this->validate(request(),[
            'img_slider'=>'required',
        ],[
            'title.required'=>'* لطفا تصویر اسلایدر را انتخاب کنید',
        ]);

        /*upload new image*/
        $slider_img_name= Str::random(45).".".$request->file('img_slider')->getClientOriginalExtension();
        $request->file('img_slider')->storeAs('/sliders/',$slider_img_name);
        $slider_record = [
            'slider_img'=>$slider_img_name,
        ];
        $sliderObj =sliderModel::create($slider_record);
        if($sliderObj instanceof sliderModel)
        {
            return redirect()->route("sliderRoute")->with('successInsert',true);
        }
    }
    public function delete_slider($slider_id=false)
    {

        if(ctype_digit($slider_id))
        {
            $deleteCategory = sliderModel::find($slider_id);
            if($deleteCategory instanceof sliderModel)
            {
                sliderModel::destroy($slider_id);
                @unlink('images/sliders/'.$deleteCategory->slider_img);
                return redirect()->route("sliderRoute")->with('successDelete',true);
            }
        }
    }
    /*End slider*/

    /*shop slider Route*/
    public function shop_slider()
    {
        $slider = ShopSliderModel::paginate("6");
        return view("Dashboard.shopSlider.index",compact("slider"));
    }
    public function edit_shopslider($slider_id=false)
    {
        if(ctype_digit($slider_id))
        {
            $slider = DB::table("tbl_shop_slider")->where("slider_id","=",$slider_id)->first();
            return view("Dashboard.shopSlider.edit",compact("slider"));
        }
        else
        {
            return false;
        }
    }
    /**
     * @param Request $request
     * @param bool $slider_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update_shopslider(Request $request, $slider_id=false)
    {
        $this->validate(request(),[
            'title'=>'required',
            'text'=>'required',
            'desc'=>'required',
        ],[
            'title.required'=>'* لطفا عنوان اسلایدر را وارد کنید',
            'text.required'=>'* لطفا متن اسلایدر را وارد کنید',
            'desc.required'=>'* لطفا توضیخات را وارد کنید را وارد کنید',
        ]);
        $slider_title = $request->input("title");
        $slider_text = $request->input("text");
        $slider_desc = $request->input("desc");
        $sliderItem = ShopSliderModel::find($slider_id);
        if($request->file('img_slider') != null)
        {
            /*delete old image*/
            @unlink('images/shop_sliders/'.$sliderItem->slider_img);
            /*upload new image*/
            $slider_img_name= Str::random(45).".".$request->file('img_slider')->getClientOriginalExtension();
            $request->file('img_slider')->storeAs('/shop_sliders/',$slider_img_name);
            $sliderData = [
                'slider_title'=>$slider_title,
                'slider_text'=>$slider_text,
                'slider_desc'=>$slider_desc,
                'slider_img'=>$slider_img_name,
            ];
        }
        else
        {
            $sliderData = [
                'slider_title'=>$slider_title,
                'slider_text'=>$slider_text,
                'slider_desc'=>$slider_desc,
            ];
        }

        $sliderItem->update($sliderData);
        return redirect()->route("ShopSliderRoute")->with('successEdit',true);
    }
    public function add_shopslider()
    {
        return view("Dashboard.shopSlider.insert");
    }
    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert_shopslider(Request $request)
    {
        $this->validate(request(),[
            'img_slider'=>'required',
        ],[
            'text.required'=>'* لطفا تصویر اسلایدر را انتخاب کنید',
        ]);

        /*upload new image*/
        $slider_img_name= Str::random(45).".".$request->file('img_slider')->getClientOriginalExtension();
        $request->file('img_slider')->storeAs('/shop_sliders/',$slider_img_name);
        $slider_record = [
            'slider_img'=>$slider_img_name,
        ];
        $sliderObj =ShopSliderModel::create($slider_record);
        if($sliderObj instanceof ShopSliderModel)
        {
            return redirect()->route("ShopSliderRoute")->with('successInsert',true);
        }

    }
    public function delete_shopslider($slider_id=false)
    {

        if(ctype_digit($slider_id))
        {
            $deleteCategory = ShopSliderModel::find($slider_id);
            if($deleteCategory instanceof ShopSliderModel)
            {
                ShopSliderModel::destroy($slider_id);
                @unlink('images/shop_sliders/'.$deleteCategory->slider_img);
                return redirect()->route("ShopSliderRoute")->with('successDelete',true);
            }
        }
    }
    /*End shop slider*/







/*discount Route*/
    public function discount(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table("tbl_discount")->orderBy('id','desc')
                ->get();
            return Datatables::of($data)
              ->editColumn('from_date', function ($data) {
                    return \Morilog\Jalali\Jalalian::forge($data->from_date)->format(' %Y/%m/%d ');
                })
                ->editColumn('to_date', function ($data) {
                    return \Morilog\Jalali\Jalalian::forge($data->to_date)->format(' %Y/%m/%d ');
                })
                ->addIndexColumn()
                
                ->addColumn('action', function($row){
                    $action = '<a href="'.route("editDiscountRoute",['id'=>$row->id]).'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">ویرایش</a>
                    <a href="'.route("deleteDiscountRoute",['id'=>$row->id]).'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-danger btn-sm editProduct">حذف</a>';
                    return $action;

                }) 
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("Dashboard.Discount.index");
    }
    
    
    public function edit_discount($discount_id=false)
    {
        if(ctype_digit($discount_id))
        {
            $discount = DB::table("tbl_discount")->where("id","=",$discount_id)->first();
             $users = DB::table("tbl_users")->where('user_type',3)->orderBy('user_id','desc')
                ->get();
            return view("Dashboard.Discount.edit",compact("discount",'users'));
        }
        else
        {
            return false;
        }
    }
    
    /**
     * @param Request $request
     * @param bool $slider_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    
    public function update_discount(Request $request, $discount_id=false)
    {
             $this->validate(request(),[
            'discount_code'=>'required',
            'status'=>'required',
            'percent'=>'required',
            'from_date'=>'required',
            'to_date'=>'required',

        ],[
            'discount_code.required'=>'* لطفا کد تخفیف را انتخاب کنید',
            'status.required'=>'* لطفا وضعیت را انتخاب کنید',
            'percent.required'=>'* لطفا درصد را انتخاب کنید',
            'from_date.required'=>'* لطفا از تاریخ را انتخاب کنید',
            'to_date.required'=>'* لطفا تا تاریخ را انتخاب کنید',

        ]);
        $fromDate = $request->input("from_date");
        $fromDate = self::convert($fromDate);
        $fromDate = explode("/",$fromDate);
        $fromDate = (new Jalalian($fromDate[0],$fromDate[1],$fromDate[2]))->toCarbon()->toDateTimeString();

        $toDate = $request->input("to_date");
        $toDate = self::convert($toDate);
        $toDate = explode("/",$toDate);
        $toDate = (new Jalalian($toDate[0],$toDate[1],$toDate[2]))->toCarbon()->toDateTimeString();
        
        $discountData = [
                'discount_code'=>$request->discount_code,
                'user_id'=>$request->user_id,
                'status'=>$request->status,
                'percent'=>$request->percent,
                'from_date'=>$fromDate,
                'to_date'=>$toDate,
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
            ];
            
        $discountItem = DiscountModel::find($discount_id);

        $discountItem->update($discountData);
        return redirect()->route("discountRoute")->with('successEdit',true);
    }
    
    
    public function add_discount()
    {
         $users = DB::table("tbl_users")->where('user_type',3)->orderBy('user_id','desc')
                ->get();
        return view("Dashboard.Discount.add",compact('users'));
    }
    
    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
     
    public function insert_discount(Request $request)
    {
        //dd($request);
        $this->validate(request(),[
            'discount_code'=>'required',
            'status'=>'required',
            'percent'=>'required',
            'from_date'=>'required',
            'to_date'=>'required',

        ],[
            'discount_code.required'=>'* لطفا کد تخفیف را انتخاب کنید',
            'status.required'=>'* لطفا وضعیت را انتخاب کنید',
            'percent.required'=>'* لطفا درصد را انتخاب کنید',
            'from_date.required'=>'* لطفا از تاریخ را انتخاب کنید',
            'to_date.required'=>'* لطفا تا تاریخ را انتخاب کنید',

        ]);
        
        $fromDate = $request->input("from_date");
        $fromDate = self::convert($fromDate);
        $fromDate = explode("/",$fromDate);
        $fromDate = (new Jalalian($fromDate[0],$fromDate[1],$fromDate[2]))->toCarbon()->toDateTimeString();

        $toDate = $request->input("to_date");
        $toDate = self::convert($toDate);
        $toDate = explode("/",$toDate);
        $toDate = (new Jalalian($toDate[0],$toDate[1],$toDate[2]))->toCarbon()->toDateTimeString();
        
        $discountData = [
                'discount_code'=>$request->discount_code,
                'user_id'=>$request->user_id,
                'status'=>$request->status,
                'percent'=>$request->percent,
                'from_date'=>$fromDate,
                'to_date'=>$toDate,
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
            ];
            
        $discountObj =DiscountModel::create($discountData);
        if($discountObj instanceof DiscountModel)
        {
            return redirect()->route("discountRoute")->with('successInsert',true);
        }

    }
    
    
    public function delete_discount($discount_id=false)
    {

        if(ctype_digit($discount_id))
        {
            $deleteDiscount = DiscountModel::find($discount_id);
            if($deleteDiscount instanceof DiscountModel)
            {
                DiscountModel::destroy($discount_id);
                return redirect()->route("discountRoute")->with('successDelete',true);
            }
        }
    }
    
    /*End Discount*/







    /*reward Route*/
    public function reward(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table("tbl_rewards")
                ->join("tbl_reward_cat","tbl_rewards.cat_id","=","tbl_reward_cat.cat_id")
                ->orderBy('reward_id','desc')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<a href="'.route("editRewardRoute",['id'=>$row->reward_id]).'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">ویرایش</a>  <a href="'.$row->reward_link.'" data-toggle="tooltip" target="_bliank"  data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">مشاهده</a>';
                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("Dashboard.Reward.index");

    }
    public function edit_reward($reward_id=false)
    {
        if(ctype_digit($reward_id))
        {
            $reward_cats=RewardcatModel::all();
            $reward = DB::table("tbl_rewards")->where("reward_id","=",$reward_id)->first();
            return view("Dashboard.Reward.edit",compact("reward","reward_cats"));
        }
        else
        {
            return false;
        }
    }

    /**
     * @param Request $request
     * @param bool $reward_id
     * @return bool|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update_reward(Request $request, $reward_id=false)
    {
        $this->validate(request(),[

            'reward_coin'=>'required|numeric',
            'anbar'=>'required',
        ],[

            'reward_coin.required'=>'وارد کردن سکه جایزه الزامیست *',
            'anbar.required'=>'وارد کردن وضعیت انبار الزامیست *',
            'reward_coin.numeric'=>'برای سکه فقط عدد وارد نمایید',
        ]);

        if(ctype_digit($reward_id))
        {
            $reward_item = RewardModel::find($reward_id);
            if($reward_item instanceof RewardModel)
            {
                $cat_id =$request->input("cat_id");
                $reward_title =$request->input("reward_title");
                $reward_desc =$request->input("reward_desc");
                $reward_coin =$request->input("reward_coin");
                $anbar =$request->input("anbar");
                $reward_link =$request->input("reward_link");
                $reward_record = [
                    "cat_id"=>$cat_id,
                    "reward_title"=>$reward_title,
                    "reward_desc"=>$reward_desc ,
                    "reward_coin"=>$reward_coin,
                    "anbar"=>$anbar,
                    "reward_link"=>$reward_link,
                ];
                if($request->file('reward_image')!= null)
                {
                    /*delete old image*/
                    @unlink('images/reward_image/'.$reward_item->reward_image);
                    /*upload new image*/
                    $reward_image= Str::random(45).".".$request->file('reward_image')->getClientOriginalExtension();
                    $request->file('reward_image')->storeAs('/reward_image/',$reward_image);
                    $reward_record["reward_image"]=$reward_image;
                }
                $reward_item->update($reward_record);
                return redirect()->route("adminRewardRoute")->with('successEdit',true);
            }
        }
        else
        {
            return false;
        }
    }
    public function add_reward()
    {
        $reward_cats = RewardcatModel::all();
        return view("Dashboard.Reward.insert",compact("reward_cats"));
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert_reward(Request $request)
    {

        $this->validate(request(),[

            'reward_coin'=>'required|numeric',
            'anbar'=>'required',
        ],[

            'reward_coin.required'=>'وارد کردن سکه جایزه الزامیست *',
            'anbar.required'=>'وارد کردن وضعیت انبار الزامیست *',
            'reward_coin.numeric'=>'برای سکه فقط عدد وارد نمایید',
        ]);

        $cat_id =$request->input("cat_id");
        $reward_title =$request->input("reward_title");
        $reward_desc =$request->input("reward_desc");
        $reward_coin =$request->input("reward_coin");
        $reward_link =$request->input("reward_link");
        $anbar =$request->input("anbar");
        $reward_record = [
            "cat_id"=>$cat_id,
            "reward_title"=>$reward_title,
            "reward_desc"=>$reward_desc,
            "reward_coin"=>$reward_coin,
            "reward_link"=>$reward_link,
            "anbar"=>$anbar,
        ];
        if($request->file('reward_image')!= null)
        {
            /*upload new image*/
            $reward_image= Str::random(45).".".$request->file('reward_image')->getClientOriginalExtension();
            $request->file('reward_image')->storeAs('/reward_image/',$reward_image);
            $reward_record["reward_image"]=$reward_image;
        }
        $bookObj =RewardModel::create($reward_record);
        if($bookObj instanceof RewardModel)
        {
            return redirect()->route("adminRewardRoute")->with('successInsert',true);
        }

    }
    public function delete_reward($reward_id=false)
    {

        if(ctype_digit($reward_id))
        {
            $deleteREW = RewardModel::find($reward_id);
            if($deleteREW instanceof RewardModel)
            {
                RewardModel::destroy($reward_id);
                @unlink('images/reward_image/'.$deleteREW->reward_image);
                return redirect()->route("adminRewardRoute")->with('successDelete',true);
            }
        }
    }
    /*End Slider*/
    /*category route*/
    public function rewardcategory()
    {
        $categories = RewardcatModel::paginate(10);
        // dd($categories);
        return view("Dashboard.RewardCategory.index",compact("categories"));
    }
    public function add_rewardcategory()
    {
        return view("Dashboard.RewardCategory.add");
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert_rewardcategory(Request $request)
    {
        $this->validate(request(),[
            'category'=>'required',
        ],[
            'category.required'=>'* لطفا نام دسته را وارد کنید',
        ]);
        $categoryRecord = [
            'cat_name'=>$request->input("category"),
        ];
        $categoryObj = RewardcatModel::create($categoryRecord);
        if($categoryObj instanceof RewardcatModel)
        {
            return redirect()->route("rewardCategoryRoute")->with('successInsert',true);
        }
    }
    public function edit_rewardcategory($category_id=false)
    {
        $category = RewardcatModel::where("cat_id","=",$category_id)->first();
        return view("Dashboard.RewardCategory.edit",compact("category"));
    }
    /**
     * @param Request $request
     * @param bool $category_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update_rewardcategory(Request $request, $category_id=false)
    {
        $this->validate(request(),[
            'category'=>'required',
        ],[
            'category.required'=>'* لطفا نام دسته را وارد کنید',
        ]);
        if(ctype_digit($category_id))
        {
            $category_item = RewardcatModel::find($category_id);
            if($category_item instanceof RewardcatModel)
            {
                $categoryRecord = [
                    "cat_name"=>$request->input("category"),
                ];
                $category_item->update($categoryRecord);
                return redirect()->route("rewardCategoryRoute")->with('successEdit',true);
            }
        }
    }
    public function delete_rewardcategory($category_id=false)
    {
        if(ctype_digit($category_id))
        {
            $deleteCategory = RewardcatModel::find($category_id);
            if($deleteCategory instanceof RewardcatModel)
            {
                RewardcatModel::destroy($category_id);
                RewardModel::where('cat_id', '=', $category_id)->delete();
                return redirect()->back()->with('successDelete',true);
            }
        }
    }
    /*end category*/
    /*contact us*/
    public function contact_us()
    {
        $messages= MessageModel::orderBy("message_state","asc")->paginate("20");
        return view("Dashboard.Contactus.index",compact("messages"));
    }

    public function contact_detail($id=false)
    {
        if(ctype_digit($id))
        {
            $message= MessageModel::where("message_id","=",$id)->first();
            if($message!=null)
            {
                $message->message_state=1;
                $message->save();
                return view("Dashboard.Contactus.details",compact("message"));
            }

        }
    }

    public function contact_delete($id=false)
    {
        if(ctype_digit($id))
        {
            $deleteRequest = MessageModel::find($id);
            if($deleteRequest instanceof MessageModel)
            {
                MessageModel::destroy($id);
                return redirect()->route("contactRoute")->with('successDelete',true);
            }
        }
    }

    /*end contact us */
    /*request money*/
    public function request_money()
    {
        $requests  = RequestmoneyModel::with("users")->orderby("request_state","asc")->paginate("20");
        return view("Dashboard.Requestmoney.index",compact("requests"));
    }
    public function request_money_details($id=false)
    {
        if(cType_digit($id))
        {
            $request = RequestmoneyModel::with("users")->find($id);
            if($request instanceof RequestmoneyModel)
            {
                return view("Dashboard.Requestmoney.details",compact("request"));
            }
        }
    }
    public function request_money_delete($id=false)
    {
        if(cType_digit($id))
        {
            $deleteRequest = RequestmoneyModel::find($id);
            if($deleteRequest instanceof RequestmoneyModel)
            {
                RequestmoneyModel::destroy($id);
                return redirect()->route("adminRequestMoneyRoute")->with('successDelete',true);
            }
        }
    }
    public function request_money_change_state($id=false)
    {
        if(cType_digit($id))
        {
            $request = RequestmoneyModel::with("users")->find($id);
            if($request instanceof RequestmoneyModel)
            {
                if($request->users->user_coin>=$request->request_coin)
                {
                    $request->users->user_coin = $request->users->user_coin-$request->request_coin;
                    $request->request_state=1;
                    $request->save();
                    $request->users->save();
                    return redirect()->back()->with('successChangeState',true);
                }
                else
                {
                    return redirect()->back()->with('errorCoin',true);
                }
            }
        }
    }
    /* end request money*/
    public function home_setting()
    {
        $setting = SettingModel::first();
        return view("Dashboard.Setting.home",compact("setting"));
    }


    public function changeCoverImage(Request $request){
        $settingObj = SettingModel::first();
        if(request()->file('image_1'))
        {
            @unlink('images/sliders/'.$settingObj->image_1);
            $image= Str::random(45).".".$request->file('image_1')->getClientOriginalExtension();
            $request->file('image_1')->storeAs('/sliders/',$image);
            $Data['image_1']=$image;
            $settingObj->update($Data);
        }
         if(request()->file('image_2'))
        {
            @unlink('images/sliders/'.$settingObj->image_2);
            $image= Str::random(45).".".$request->file('image_2')->getClientOriginalExtension();
            $request->file('image_2')->storeAs('/sliders/',$image);
            $Data['image_2']=$image;
            $settingObj->update($Data);
        }
         if(request()->file('image_3'))
        {
            @unlink('images/sliders/'.$settingObj->image_3);
            $image= Str::random(45).".".$request->file('image_3')->getClientOriginalExtension();
            $request->file('image_3')->storeAs('/sliders/',$image);
            $Data['image_3']=$image;
            $settingObj->update($Data);
        }
         if(request()->file('image_4'))
        {
            @unlink('images/sliders/'.$settingObj->image_4);
            $image= Str::random(45).".".$request->file('image_4')->getClientOriginalExtension();
            $request->file('image_4')->storeAs('/sliders/',$image);
            $Data['image_4']=$image;
            $settingObj->update($Data);
        }
         if(request()->file('image_5'))
        {
            @unlink('images/sliders/'.$settingObj->image_5);
            $image= Str::random(45).".".$request->file('image_5')->getClientOriginalExtension();
            $request->file('image_5')->storeAs('/sliders/',$image);
            $Data['image_5']=$image;
            $settingObj->update($Data);
        }
         if(request()->file('image_6'))
        {
            @unlink('images/sliders/'.$settingObj->image_6);
            $image= Str::random(45).".".$request->file('image_6')->getClientOriginalExtension();
            $request->file('image_6')->storeAs('/sliders/',$image);
            $Data['image_6']=$image;
            $settingObj->update($Data);
        }
         if(request()->file('image_7'))
        {
            @unlink('images/sliders/'.$settingObj->image_7);
            $image= Str::random(45).".".$request->file('image_7')->getClientOriginalExtension();
            $request->file('image_7')->storeAs('/sliders/',$image);
            $Data['image_7']=$image;
            $settingObj->update($Data);
        }
         if(request()->file('image_8'))
        {
            @unlink('images/sliders/'.$settingObj->image_8);
            $image= Str::random(45).".".$request->file('image_8')->getClientOriginalExtension();
            $request->file('image_8')->storeAs('/sliders/',$image);
            $Data['image_8']=$image;
            $settingObj->update($Data);
        }
    }
    public function home_setting_post(Request $request)
    {

        if($request->input("s1")=="on") $s1=1; else $s1=0;
        if($request->input("s2")=="on") $s2=1; else $s2=0;
        if($request->input("s3")=="on") $s3=1; else $s3=0;
        if($request->input("s4")=="on") $s4=1; else $s4=0;
        if($request->input("s5")=="on") $s5=1; else $s5=0;
        if($request->input("s6")=="on") $s6=1; else $s6=0;
        if($request->input("s7")=="on") $s7=1; else $s7=0;
        if($request->input("s8")=="on") $s8=1; else $s8=0;
        if($request->input("s9")=="on") $s9=1; else $s9=0;
        if($request->input("s10")=="on") $s10=1; else $s10=0;
        $settingObject = SettingModel::first();
        $settingObject->s1=$s1;
        $settingObject->s2=$s2;
        $settingObject->s3=$s3;
        $settingObject->s4=$s4;
        $settingObject->s5=$s5;
        $settingObject->s6=$s6;
        $settingObject->s7=$s7;
        $settingObject->s8=$s8;
        $settingObject->s9=$s9;
        $settingObject->s10=$s10;
        $settingObject->link_1=$request->input("link_1");
        $settingObject->link_2=$request->input("link_2");
        $settingObject->link_3=$request->input("link_3");
        $settingObject->link_4=$request->input("link_4");
        $settingObject->link_5=$request->input("link_5");
        $settingObject->link_6=$request->input("link_6");
        $settingObject->link_7=$request->input("link_7");
        $settingObject->link_8=$request->input("link_8");

        $settingObject->save();
        return redirect()->back()->with('successEdit',true);
    }

    public function setting()
    {
        $setting = SettingModel::first();
        return view("Dashboard.Setting.Index",compact("setting"));
    }
    public function setting_post(Request $request)
    {
        $this->validate(request(),[
            'address'=>'required',
            'email'=>'required',
            'mobile'=>'required',
            'about'=>'required',
            'price_coin'=>'required',

        ],[
            'address.required'=>'* لطفا آدرس را وارد کنید',
            'email.required'=>'* لطفا ایمیل را وارد کنید',
            'mobile.required'=>'* لطفا موبایل را وارد کنید',
            'about.required'=>'* لطفا متن درباره ما را وارد کنید',
            'price_coin.required'=>'* لطفا مبلغ هر سکه را وارد کنید',
        ]);
        if($request->input("convert_state")!=null)
        {
            $state="1";
        }
        elseif($request->input("convert_state")==null)
        {
            $state="0";
        }
        $settingObject = SettingModel::first();
        $settingObject->convert_coin_state=$state;
        $settingObject->address=$request->input("address");
        $settingObject->email=$request->input("email");
        $settingObject->mobile=$request->input("mobile");
        $settingObject->about_text=$request->input("about");
        $settingObject->price_coin=$request->input("price_coin");
        $settingObject->coin_identifier=$request->input("coin_identifier");
        $settingObject->save();
        return redirect()->back()->with('successEdit',true);
    }

    public function request_reward($id=false)
    {
            if($id==false)
         {
            $requests = DB::table('tbl_reward_request')
                ->leftJoin('tbl_users','tbl_users.user_id','=','tbl_reward_request.user_id')
                ->leftJoin('tbl_rewards','tbl_rewards.reward_id','=','tbl_reward_request.reward_id')
                ->orderby("request_id","desc")
                ->paginate("8");
             //$requests = RequestRewardModel::with("reward")->with("users")->orderby("request_id","desc")->paginate("8");
         }
         else
         {
             $requests = DB::table('tbl_reward_request')
                ->leftJoin('tbl_users','tbl_users.user_id','=','tbl_reward_request.user_id')
                ->leftJoin('tbl_rewards','tbl_rewards.reward_id','=','tbl_reward_request.reward_id')
                ->orderby("request_id","desc")
                ->where("request_state","=",$id)
                ->paginate("8");
         //$requests = RequestRewardModel::where("request_state","=",$id)->with("reward")->with("users")->paginate("8");
         }
            return view("Dashboard.RequestReward.Index",compact("requests"));
    }
    public function request_reward_delete($id=false)
    {
        if(cType_digit($id))
        {
            $deleteReward = RequestRewardModel::find($id);
            if($deleteReward instanceof RequestRewardModel)
            {
                RequestRewardModel::destroy($id);
                return redirect()->route("adminRequestRewardRoute")->with('successDelete',true);
            }
        }
    }
    public function request_reward_single($id=false)
    {
        if(cType_digit($id))
        {
            $request = RequestRewardModel::with("users")->with("reward")->find($id);
            if($request instanceof RequestRewardModel)
            {
                return view("Dashboard.RequestReward.Details",compact("request"));
            }
        }
    }
    public function request_reward_change_state($id=false)
    {
        if(cType_digit($id))
        {
            $request = RequestRewardModel::with("users")->find($id);
            if($request instanceof RequestRewardModel)
            {
                $request->request_state=2;
                $request->save();
                return redirect()->back()->with('successChangeState',true);
            }
        }
    }
    public function logout()
    {
        Session()->forget("admin_username");
        Session()->forget("admin_user_id");
        Session()->forget("admin_user_flname");
        Session()->forget("admin_user_mobile");
        return redirect()->route("AdminLoginRoute");
    }
    //saeed
    public function usersList(Request $request)
    {
      /*  $users = UserModel::select()->orderBy('user_id','DESC')->paginate(10);
        for($i=0;$i<count($users);$i++)
        {
            if ($users[$i]['introduced']!=null)
            {
                $user = UserModel::where('identifier_code',$users[$i]['introduced'])->first();
                if($user instanceof UserModel)
                {
                    $users[$i]['name_introduced'] = $user->user_name;
                }
                else
                {
                    $temp = null;
                    $update = UserModel::where('user_id', $users[$i]['user_id'])
                        ->update(['introduced' => $temp]);
                    $users[$i]['introduced'] = $temp;
                }
            }
        }
        //$users = UserModel::select()->paginate(10);
        $books = DB::table('tbl_users')
            ->join('tbl_orders','tbl_users.user_id','=','tbl_orders.user_id')
            ->select('tbl_orders.user_id as uid',DB::raw("sum(tbl_orders.price) as price"),DB::raw("count(tbl_orders.user_id) as count"))
            ->where('tbl_orders.order_state',2)
            ->groupBy('tbl_orders.user_id')
            ->get();
        $reward = DB::table('tbl_users')
            ->join('tbl_reward_request','tbl_users.user_id','=','tbl_reward_request.user_id')
            ->select('tbl_reward_request.user_id as uid',DB::raw("count(tbl_reward_request.user_id) as count"))
            ->where('tbl_reward_request.request_state',2)
            ->groupBy('tbl_reward_request.user_id')
            ->get();
        for($i=0;$i<count($books);$i++)
        {
            for($j=0;$j<count($users);$j++)
            {
                if($books[$i]->uid == $users[$j]->user_id)
                {
                    $users[$j]['price'] = $books[$i]->price;
                    $users[$j]['count'] = $books[$i]->count;
                }
            }
        }
        for($i=0;$i<count($reward);$i++)
        {
            for($j=0;$j<count($users);$j++)
            {
                if($reward[$i]->uid == $users[$j]->user_id)
                {
                    $users[$j]['reward'] = $reward[$i]->count;
                }
            }
        }*/
                if ($request->ajax()) {
            $data = UserModel::select()->where('user_type','!=',2)->orderBy('user_id','DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<a href="'.route("usersEditRoute",['id'=>$row->user_id]).'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">ویرایش</a>';
                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("Dashboard.Users.index");
    }
    public function userEdit($id){
        $awards = DB::table('tbl_users')
            ->join('tbl_reward_request','tbl_users.user_id','=','tbl_reward_request.user_id')
            ->join('tbl_rewards','tbl_rewards.reward_id','=','tbl_reward_request.reward_id')
            ->where('tbl_users.user_id',$id)
            ->paginate(10);
        $user = UserModel::find($id);
        $matchs = DB::table("tbl_codes")
            ->join("tbl_quiz","tbl_codes.quiz_id","=","tbl_quiz.quiz_id")
            ->select('tbl_codes.code_text','tbl_codes.code_number','tbl_codes.quiz_state','tbl_quiz.quiz_name','tbl_codes.quiz_date','tbl_codes.user_coin')
            ->where('tbl_codes.user_id','=',$id)->orderBy('quiz_date','desc')->paginate("10");
         $orders = DB::table("tbl_orders")
            ->join("tbl_books","tbl_books.book_id","=","tbl_orders.book_id")
            ->orderByDesc('order_id')
            ->where("tbl_orders.user_id",$id)
           ->paginate(10);
           
           //discounter data 
		$discount = DiscountModel::where('user_id',$id)->first();
		if(isset($discount)){
            $datas = DB::table("tbl_users")
        ->join("tbl_shopping_cart","tbl_shopping_cart.user_id","=","tbl_users.user_id") //جوین کاربر و سبد خرید
        ->join("tbl_cart_items","tbl_cart_items.shopping_cart_id","=","tbl_shopping_cart.id") //جوین ایتم سبذ خرید با سبد خرید
        ->join("tbl_books","tbl_cart_items.product_id","=","tbl_books.book_id") //جوین ایتم سبذ خرید با محصولات
        ->select("tbl_books.book_name as book_name","tbl_cart_items.created_at as created_at","tbl_books.price as price","tbl_users.user_name as user_name","tbl_shopping_cart.discount_code as discount_code")
        ->where('tbl_shopping_cart.discount_code','=',$discount->discount_code)->paginate(50);
           }
           
           
        return view("Dashboard.Users.edit",compact("awards","user","matchs","orders","datas"));
    }
    public function userUpdate(Request $request){
        $this->validate(request(),[
            'user_type'=>'required',
        ],[
            'user_type.required'=>'* لطفا نقش را انتخاب کنید',
        ]);
        if(ctype_digit($request->input("user_id")))
        {
            $user_item = UserModel::find($request->input("user_id"));
            if($user_item instanceof UserModel)
            {
                $user_record = [
                    "user_type"=>$request->input("user_type"),
                    "user_coin"=>$request->input("user_coin")
                ];
                $user_item->update($user_record);
                return redirect()->route("usersListRoute")->with('successEdit',true);
            }
        }
        
    }
    public function userBooks($id)
    {
        $books = DB::table('tbl_users')
            ->join('tbl_orders','tbl_users.user_id','=','tbl_orders.user_id')
            ->join('tbl_books','tbl_books.book_id','=','tbl_orders.book_id')
            ->where('tbl_orders.order_state',2)
            ->where('tbl_users.user_id',$id)
            ->select()
            ->paginate(10);
        return view("Dashboard.Users.books",compact("books"));
    }
    public function userRewards($id)
    {

        $rewards = DB::table('tbl_users')
            ->join('tbl_reward_request','tbl_users.user_id','=','tbl_reward_request.user_id')
            ->join('tbl_rewards','tbl_rewards.reward_id','=','tbl_reward_request.reward_id')
            ->select()
            ->where('tbl_reward_request.request_state',2) ->where('tbl_reward_request.user_id',$id)
            ->paginate(10);
        return view("Dashboard.Users.reward",compact("rewards"));
    }
    public function searchCode()
    {
        $this->validate(request(),[
            'search_code'=>'required',
        ],[
            'search_code.required'=>'* لطفا کد پیگیری را وارد کنید',
        ]);
        $code = $_GET['search_code'];
        $orders = DB::table("tbl_orders")->where('tracking_code', '=', $code)->join("tbl_users","tbl_users.user_id","=","tbl_orders.user_id")->join("tbl_books","tbl_books.book_id","=","tbl_orders.book_id")->orderby("order_id","desc")->paginate("8");



        return view("Dashboard.Orders.index",compact("orders"));
    }
    public function searchUser()
    {
        $this->validate(request(),[
            'search_user'=>'required',
        ],[
            'search_user.required'=>'* لطفا نام مستعار را وارد کنید',
        ]);
        $search = $_GET['search_user'];
        $users = UserModel::select()->where('user_name', 'like', "%" . $search . "%")->paginate(10);
        $books = DB::table('tbl_users')
            ->join('tbl_orders','tbl_users.user_id','=','tbl_orders.user_id')
            ->select('tbl_orders.user_id as uid',DB::raw("sum(tbl_orders.price) as price"),DB::raw("count(tbl_orders.user_id) as count"))
            ->where('tbl_orders.order_state',2)
            ->groupBy('tbl_orders.user_id')
            ->get();
        $reward = DB::table('tbl_users')
            ->join('tbl_reward_request','tbl_users.user_id','=','tbl_reward_request.user_id')
            ->select('tbl_reward_request.user_id as uid',DB::raw("count(tbl_reward_request.user_id) as count"))
            ->where('tbl_reward_request.request_state',2)
            ->groupBy('tbl_reward_request.user_id')
            ->get();
        for($i=0;$i<count($books);$i++)
        {
            for($j=0;$j<count($users);$j++)
            {
                if($books[$i]->uid == $users[$j]->user_id)
                {
                    $users[$j]['price'] = $books[$i]->price;
                    $users[$j]['count'] = $books[$i]->count;
                }
            }
        }
        for($i=0;$i<count($reward);$i++)
        {
            for($j=0;$j<count($users);$j++)
            {
                if($reward[$i]->uid == $users[$j]->user_id)
                {
                    $users[$j]['reward'] = $reward[$i]->count;
                }
            }
        }
        return view("Dashboard.Users.index",compact("users"));
    }
    public function searchBook()
    {
        $this->validate(request(),[
            'search_book'=>'required',
        ],[
            'search_book.required'=>'* لطفا نام کتاب را وارد کنید',
        ]);
        $search = $_GET['search_book'];
        $users = UserModel::
        join('tbl_orders','tbl_users.user_id','=','tbl_orders.user_id')
            ->join('tbl_books','tbl_books.book_id','=','tbl_orders.book_id')
            ->where('tbl_orders.order_state',2)
            ->where('tbl_books.book_name', 'like', "%" . $search . "%")
            ->select('tbl_users.*')
            ->distinct('tbl_users.user_id')
            ->paginate(10);
        $books = DB::table('tbl_users')
            ->join('tbl_orders','tbl_users.user_id','=','tbl_orders.user_id')
            ->select('tbl_orders.user_id as uid',DB::raw("sum(tbl_orders.price) as price"),DB::raw("count(tbl_orders.user_id) as count"))
            ->where('tbl_orders.order_state',2)
            ->groupBy('tbl_orders.user_id')
            ->get();
        $reward = DB::table('tbl_users')
            ->join('tbl_reward_request','tbl_users.user_id','=','tbl_reward_request.user_id')
            ->select('tbl_reward_request.user_id as uid',DB::raw("count(tbl_reward_request.user_id) as count"))
            ->where('tbl_reward_request.request_state',2)
            ->groupBy('tbl_reward_request.user_id')
            ->get();
        for($i=0;$i<count($books);$i++)
        {
            for($j=0;$j<count($users);$j++)
            {
                if($books[$i]->uid == $users[$j]->user_id)
                {
                    $users[$j]['price'] = $books[$i]->price;
                    $users[$j]['count'] = $books[$i]->count;
                }
            }
        }
        for($i=0;$i<count($reward);$i++)
        {
            for($j=0;$j<count($users);$j++)
            {
                if($reward[$i]->uid == $users[$j]->user_id)
                {
                    $users[$j]['reward'] = $reward[$i]->count;
                }
            }
        }
        return view("Dashboard.Users.index",compact("users"));
    }
    public function findIntroduced($id)
    {
        $user = UserModel::where('identifier_code',$id)->first();
        if($user instanceof UserModel)
        {
            //dd($user);
        }
        $books = DB::table('tbl_users')
            ->join('tbl_orders','tbl_users.user_id','=','tbl_orders.user_id')
            ->join('tbl_books','tbl_books.book_id','=','tbl_orders.book_id')
            ->where('tbl_orders.order_state',2)
            ->where('tbl_users.introduced',$id)
            ->select()
            ->paginate(10);
        $sum_price = 0;
        for($j=0;$j<count($books);$j++)
        {
            $sum_price = $sum_price + $books[$j]->price;
        }
        return view("Dashboard.Users.booksIntroduced",compact("books","user","sum_price"));
    }
    //saeed

    /* Start Post Functions */

    public function listPosts(Request $request)
    {

        if ($request->ajax()) {
            $data = DB::table('tbl_posts')
                ->join('tbl_post_category','tbl_post_category.category_id','=','tbl_posts.category_id')
                ->select('tbl_posts.status as status','tbl_posts.id as id','tbl_posts.title as title','tbl_posts.media as media','tbl_posts.created_at as date','tbl_post_category.category_name as category')
                ->orderByDesc('id')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<a href="'.route("editPost",['id'=>$row->id]).'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">ویرایش</a>';
                    return $action;

                })
                ->rawColumns(['action'])
                ->editColumn('status', function ($data) {
                    if($data->status == "2024")
                    {
                        return "فعال";
                    }
                    if($data->status == "2023")
                    {
                        return "غیرفعال";
                    }
                })
                ->make(true);
        }


        return view("Dashboard.Post.index");

    }

    public function editComment($id=false)
    {
        if($id) {
            $data =CommentModel::find($id);
            return view('Dashboard.Comments.edit',compact('data'));
        }
    }

    public function updateComment(Request $request)
    {
        $this->validate(request(),[
            'text'=>'required',
            'status'=>'required',
        ],[
            'status.required'=>'* لطفا وضعیت انتشار را مشخص کنید',
            'text.required'=>'* لطفا متن کامنت را وارد نمایید',
        ]);
        $status=$request->input('status');
        $text=$request->input('text');
        $comment_id = $request->comment_id;
        $commentItem = CommentModel::find($comment_id);
        $comment_record = [
            'text'=>$text,
            'status'=>$status,
        ];
        $commentItem->update($comment_record);
        if($commentItem->type == 1)  return redirect()->route("dashboardListCommentsPosts")->with('message','success');
        else if($commentItem->type == 2)  return redirect()->route("dashboardListCommentsBooks")->with('message','success');
        else if($commentItem->type == 3)  return redirect()->route("dashboardListCommentsRewards")->with('message','success');

       
    }
    public function change_comment_read_state(Request $request){
        $comment_id = $request->id;
        if(ctype_digit($comment_id)){
        $commentItem = CommentModel::find($comment_id);
        $comment_record = [
            'read_state'=>2
        ];
        $commentItem->update($comment_record);
        }
        return  redirect()->back()->with('message','success');
    }

    public function listCommentsBooks(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tbl_books')
                ->join('tbl_comments','tbl_books.book_id','=','tbl_comments.foreign_id')
                ->leftJoin('tbl_users','tbl_users.user_id','=','tbl_comments.user_id')
                ->select('tbl_users.user_flname',
                    'tbl_comments.text',
                    'tbl_comments.foreign_id as foreign_id',
                    'tbl_comments.id',
                    'tbl_comments.type',
                    'tbl_comments.status',
                    'tbl_comments.read_state',
                    'tbl_books.book_name as book_namee',
                    'tbl_comments.created_at')
                ->where('tbl_comments.type','=',2)
                ->orderByDesc('id')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<a href="'.route("editComment",['id'=>$row->id]).'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">ویرایش</a>';
                    if($row->read_state == 1) $action .='<a style="margin:0 15px; color:red;font-size: 28px; vertical-align: text-bottom;" href="'.route("change_comment_read_state",['id'=>$row->id]).'"  <i class="zmdi zmdi-eye-off"></i></a>'; 
                    return $action;

                })
                ->addColumn('book_name', function ($data) {
                    return '<a href="'.route('singleBookRoute',['id'=>$data->foreign_id]).'" data-toggle="tooltip"  data-original-title="show" class="edit btn btn-danger btn-sm editProduct">'.$data->book_namee.'</a';
                })
               ->rawColumns(['action','book_name'])
                ->editColumn('status', function ($data) {
                    if($data->status == "1")
                    {
                        return "فعال";
                    }
                    if($data->status == "2")
                    {
                        return "غیرفعال";
                    }
                })
                ->editColumn('user_flname', function ($data) {
                    if($data->user_flname == null)
                    {
                        return "کاربر مهمان";
                    }
                    else
                    {
                        return $data->user_flname;
                    }
                })
                ->make(true);
        }


        return view("Dashboard.Comments.indexBooks");

    }
    
    public function listCommentsRewards(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tbl_rewards')
                ->join('tbl_comments','tbl_rewards.reward_id','=','tbl_comments.foreign_id')
                ->leftJoin('tbl_users','tbl_users.user_id','=','tbl_comments.user_id')
                ->select('tbl_users.user_flname',
                    'tbl_comments.text',
                    'tbl_comments.foreign_id as foreign_id',
                    'tbl_comments.id',
                    'tbl_comments.type',
                    'tbl_comments.status',
                    'tbl_comments.read_state',
                    'tbl_rewards.reward_title as reward_title',
                    'tbl_comments.created_at')
                ->where('tbl_comments.type','=',3)
                ->orderByDesc('id')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<a href="'.route("editComment",['id'=>$row->id]).'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">ویرایش</a>';
                    if($row->read_state == 1) $action .='<a style="margin:0 15px; color:red;font-size: 28px; vertical-align: text-bottom;" href="'.route("change_comment_read_state",['id'=>$row->id]).'"  <i class="zmdi zmdi-eye-off"></i></a>'; 

                    return $action;

                })
                ->editColumn('reward_name', function ($data) {
                    return '<a href="'.route('singleRewardRoute',['id'=>$data->foreign_id]).'" data-toggle="tooltip"  data-original-title="show" class="edit btn btn-danger btn-sm editProduct">'.$data->reward_title.'</a';
                })
               ->rawColumns(['action','reward_name'])
                ->editColumn('status', function ($data) {
                    if($data->status == "1")
                    {
                        return "فعال";
                    }
                    if($data->status == "2")
                    {
                        return "غیرفعال";
                    }
                })
                ->editColumn('user_flname', function ($data) {
                    if($data->user_flname == null)
                    {
                        return "کاربر مهمان";
                    }
                    else
                    {
                        return $data->user_flname;
                    }
                })
                ->make(true);
        }


        return view("Dashboard.Comments.indexRewards");

    }
    
    public function listCommentsPosts(Request $request)
    {

               // dd($data);
        if ($request->ajax()) {
            $data = DB::table('tbl_posts')
                ->join('tbl_comments','tbl_posts.id','=','tbl_comments.foreign_id')
                ->leftJoin('tbl_users','tbl_users.user_id','=','tbl_comments.user_id')
                ->select('tbl_users.user_flname',
                    'tbl_comments.text',
                    'tbl_comments.foreign_id as foreign_id',
                    'tbl_comments.id as id',
                    'tbl_comments.type',
                    'tbl_comments.status',
                    'tbl_comments.read_state',
                    'tbl_posts.title as titlee',
                    'tbl_posts.slug as slug',
                    'tbl_comments.created_at')
                ->where('tbl_comments.type','=',1)
                ->orderByDesc('id')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<a href="'.route("editComment",['id'=>$row->id]).'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">ویرایش</a>';
                    if($row->read_state == 1) $action .='<a style="margin:0 15px; color:red;font-size: 28px; vertical-align: text-bottom;" href="'.route("change_comment_read_state",['id'=>$row->id]).'"  <i class="zmdi zmdi-eye-off"></i></a>'; 
                    return $action;

                })
                ->editColumn('title', function ($data) {
                    return '<a href="'.route('singleBlogRoute',['slug'=>$data->slug]).'" data-toggle="tooltip"  data-original-title="show" class="edit btn btn-danger btn-sm editProduct">'.$data->titlee.'</a';
                })
               ->rawColumns(['action','title'])
                ->editColumn('status', function ($data) {
                    if($data->status == "1")
                    {
                        return "فعال";
                    }
                    if($data->status == "2")
                    {
                        return "غیرفعال";
                    }
                })
                ->editColumn('user_flname', function ($data) {
                    if($data->user_flname == null)
                    {
                        return "کاربر مهمان";
                    }
                    else
                    {
                        return $data->user_flname;
                    }
                })
                ->make(true);
        }


        return view("Dashboard.Comments.indexPosts");

    }

    public function addPost()
    {
        $category=CategoryPostModel::all();
        return view('Dashboard.Post.add',compact('category'));
    }

    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insertPost(Request $request)
    {
        $this->validate(request(),[
            'category'=>'required',
            'title'=>'required',
            'status'=>'required',
            'slug'=>'required',
        ],[
            'status.required'=>'* لطفا وضعیت انتشار را مشخص کنید',
            'title.required'=>'* لطفا عنوان را وارد نمایید',
            'slug.required'=>'* لطفا آدرس را وارد نمایید',
            'category.required'=>'* لطفا دسته بندی را مشخص کنید',
        ]);

        /*upload new image*/

        $description=$request->input('description');
        $category=$request->input('category');
        $status=$request->input('status');
        $slug=$request->input('slug');
        $title=$request->input('title');
        $post = new PostModel();
        $post->description = $description;
        $post->title = $title;
        $post->slug = $slug;
        $post->category_id = $category;
        $post->status = $status;
        if($request->file('image')){
            $post_img_name= Str::random(45).".".$request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('/post/',$post_img_name);
            $post->media = $post_img_name;
        }
        $post->save();

        if($post instanceof PostModel)
        {
            return redirect()->route("dashboardListPosts")->with('message','success');
        }
    }

    public function editPost($post_id=false)
    {
        if($post_id) {
            $category=CategoryPostModel::all();
            $post =PostModel::find($post_id);
            return view('Dashboard.Post.edit',compact('post','category'));
        }
    }

    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePost(Request $request)
    {
        $this->validate(request(),[
            'category'=>'required',
            'title'=>'required',
            'status'=>'required',
        ],[
            'status.required'=>'* لطفا وضعیت انتشار را مشخص کنید',
            'title.required'=>'* لطفا عنوان را وارد نمایید',
            'category.required'=>'* لطفا دسته بندی را مشخص کنید',
        ]);

        $description=$request->input('description');
        $category=$request->input('category');
        $status=$request->input('status');
        $title=$request->input('title');
        $slug=$request->input('slug');
        $author=8;
        $post_id = $request->post_id;
        $postItem = PostModel::find($post_id);
        $post_record = [
            'description'=>$description,
            'title'=>$title,
            'category_id'=>$category,
            'status'=>$status,
            'author_id'=>$author,
            'slug'=>$slug,
        ];
        if($request->file('image') != null)
        {
            /*delete old image*/
            @unlink('images/post/'.$postItem->media);
            /*upload new image*/
            $post_img_name= Str::random(45).".".$request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('/post/',$post_img_name);
            $post_record["media"]=$post_img_name;

        }


        $postItem->update($post_record);
        return redirect()->route("dashboardListPosts")->with('message','success');
    }

    public function deletePost(Request $request)
    {
        $post_id=$request->input('post_id');
        if(ctype_digit($post_id))
        {
            $deletePost = PostModel::find($post_id);
            if($deletePost instanceof PostModel)
            {
                PostModel::destroy($post_id);
                @unlink('images/post/'.$deletePost->media);
                return redirect()->route("dashboardListPosts")->with('message','success');
            }
        }
    }

    public function upload_image_cke(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('fava'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('fava/' . $fileName);
            $msg = 'فایل با موفقیت بارگذاری شد.';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;

        }
    }

    /* End Post Functions */

    /* Start post category Functions */

    public function postcategory()
    {
        $categories = CategoryPostModel::paginate(10);
        return view("Dashboard.Categorypost.index",compact("categories"));
    }
    public function add_postcategory()
    {
        return view("Dashboard.Categorypost.add");
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert_postcategory(Request $request)
    {
        $this->validate(request(),[
            'title'=>'required',
            'slug'=>'required',

        ],[
            'title.required'=>'* لطفا نام دسته را وارد کنید',
            'slug.required'=>'* لطفا آدرس دسته را وارد کنید',
        ]);

        $title=$request->input('title');
        $slug=$request->input('slug');
        $categoryObj = new CategoryPostModel();
        $categoryObj->category_name = $title;
        $categoryObj->category_slug = $slug;
        if($request->file('image')){
            $cat_img_name= Str::random(45).".".$request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('/post_category/',$cat_img_name);
            $categoryObj->category_media = $cat_img_name;
        }
        $categoryObj->save();
        if($categoryObj instanceof CategoryPostModel)
        {
            return redirect()->route("postCategoryRoute")->with('successInsert',true);
        }
    }
    public function edit_postcategory($category_id=false)
    {
        $category = CategoryPostModel::where("category_id","=",$category_id)->first();
        return view("Dashboard.Categorypost.edit",compact("category"));
    }
    /**
     * @param Request $request
     * @param bool $category_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update_postcategory(Request $request, $category_id=false)
    {
        $this->validate(request(),[
            'title'=>'required',
            'slug'=>'required',

        ],[
            'title.required'=>'* لطفا نام دسته را وارد کنید',
            'slug.required'=>'* لطفا آدرس دسته را وارد کنید',
        ]);
        if(ctype_digit($category_id))
        {
            $category_item = CategoryPostModel::find($category_id);
            if($category_item instanceof CategoryPostModel)
            {
                $categoryRecord = [
                    "category_name"=>$request->input("category"),
                    "category_slug"=>$request->input("slug"),
                ];
                if($request->file('image') != null)
                {
                    /*delete old image*/
                    @unlink('images/post_category/'.$category_item->media);
                    /*upload new image*/
                    $post_img_name= Str::random(45).".".$request->file('image')->getClientOriginalExtension();
                    $request->file('image')->storeAs('/post_category/',$post_img_name);
                    $categoryRecord["category_media"]=$post_img_name;

                }
                $category_item->update($categoryRecord);
                return redirect()->route("postCategoryRoute")->with('successEdit',true);
            }
        }
    }
    public function delete_postcategory($category_id=false)
    {
        if(ctype_digit($category_id))
        {
            $deleteCategory = RewardcatModel::find($category_id);
            if($deleteCategory instanceof RewardcatModel)
            {
                RewardcatModel::destroy($category_id);
                RewardModel::where('cat_id', '=', $category_id)->delete();
                return redirect()->back()->with('successDelete',true);
            }
        }
    }

    /* End post category Functions */
}
