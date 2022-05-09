<?php

namespace App\Providers;

use App\Models\BookCatModel;
use App\Models\RequestRewardModel;
use App\Models\OrderModel;
use App\Models\CommentModel;
use App\Models\RewardcatModel;
use App\Models\SettingModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\UserModel;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $request_reward=RequestRewardModel::where('request_state', '=', 1)->count();
       
        $request_order=OrderModel::where('ref_id', '!=', '0')->where('order_state', '=', '0')->count();
        $post_alert=CommentModel::where('read_state', '=', 1)->where('type', '=', 1)->count();
        $book_alert=CommentModel::where('read_state', '=', 1)->where('type', '=', 2)->count();
        $reward_alert=CommentModel::where('read_state', '=', 1)->where('type', '=', 3)->count();

        //dd($request_reward,$request_order);
        $user_id = Session::get('user_id');
        $cats=BookCatModel::all();
        $catRewards = RewardCatModel::all();
        $user_state ="";
        if($user_id!=null) {
            $user_state ="logined";
        }
        $data = SettingModel::first();
        View::share('setting', $data);
        View::share('user_state',$user_state);
        View::share('catRewards',$catRewards);
        View::share('cats',$cats);
        View::share('request_reward1',$request_reward);
        View::share('request_order1',$request_order);
        View::share('post_alert',$post_alert);
        View::share('book_alert',$book_alert);
        View::share('reward_alert',$reward_alert);

        
    }
}
