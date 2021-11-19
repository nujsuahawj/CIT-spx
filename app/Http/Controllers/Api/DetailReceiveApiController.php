<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Condition\Customer;
use App\Models\Settings\Branch;
use App\Models\Settings\Province;
use App\Models\Settings\District;
use App\Models\Settings\Village;
use App\Models\Settings\GoodsType;
use App\Models\Settings\Exchange;
use App\Models\Condition\ProductType;
use App\Models\Settings\CalculatePrice;
use App\Models\Transaction\Matterail;
use App\Models\Transaction\ListMatterail;
use App\Models\Transaction\ReceiveTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class DetailReceiveApiController extends Controller
{

    public function index(){
        $currentURL = \Request::segment(2);
        $user  = Auth()->user()->branchname->id;

        $vch = ReceiveTransaction::select('receive_transactions.code','csd.name as cs','csd.phone as ps','crc.name as cr','crc.phone as pr','bs.company_name_la as bs','bc.company_name_la as bc',
        'receive_transactions.amount','receive_transactions.currency_code','receive_transactions.valuedt','receive_transactions.service_type')
       ->join('customers as csd','receive_transactions.customer_send','=','csd.id')
       ->join('customers as crc','receive_transactions.customer_receive','=','crc.id')
       ->join('branches as bs','receive_transactions.branch_send','=','bs.id')
       ->join('branches as bc','receive_transactions.branch_receive','=','bc.id')
       ->where('receive_transactions.code', $currentURL)->first();
        $mtl=Matterail::select('matterails.code','matterails.large','matterails.height','matterails.longs','matterails.weigh','pd.name as pd','matterails.amount','matterails.cod_amount',
                               'matterails.currency_code','matterails.cod_amount','matterails.paid_type') 
                       ->join('list_matterails as lm','matterails.code','=','lm.mcode')
                       ->join('product_types as pd','matterails.product_type_id','=','pd.id')
                       ->where('lm.rvcode',$currentURL)->get();
                    
        $ex=Exchange::select('*')->where('ex_date')->first();
        if(empty($ex->ex_date))
        {
            $ex=Exchange::select('ex_date','currency_one','rate_one','currency_two','rate_two')
            ->where('ex_date')
            ->orderBy('ex_date','desc')->first();
        }

        $user = User::where('id')->first();
        return response()->json([]);
    }

}
