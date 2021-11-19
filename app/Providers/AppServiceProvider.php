<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Models\Settings\Branch;
use App\Models\Web\Message;
use App\Models\CallGoods;

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
        $address = Branch::select('company_name_la','company_name_en','address_la','address_en','phone','director','whatsapp','facebook_fanpage','youtube','google_map','app_store','play_store','app_gallery')->where('id',1)->first();
        $messages = Message::where('status',1)->count();
        $callgood = CallGoods::where('status', 1)->orderBy('id','desc')->get();
        $count_callgood = CallGoods::where('status', 1)->count('id');
        View::share(['address'=> $address, 'messages'=>$messages, 'callgood'=>$callgood, 'count_callgood'=>$count_callgood]);
    }
}
