<?php

namespace App\Http\Livewire\Admin\ReceiveStock;

use Livewire\Component;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticTransection;
use App\Models\Transaction\CreateTraffic;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use Carbon\Carbon;
use DB;

class ListReceiveStockComponent extends Component
{

    public $search, $code;

    public function render()
    {
        $shipout = LogisticDetail::select('logistic_details.id as id', 'logistic_details.rvcode','logistic_details.receive_date','logistic_details.status', 'logistics.code', 'logistics.trf_code', 'branches.company_name_la', 'branches.company_name_en', 'users.name')
            ->join('logistics','logistic_details.lgt_id','=','logistics.id')
            ->join('branches','logistic_details.sender_unit','=','branches.id')
            ->join('users','logistic_details.user_receive','=','users.id')
            ->where(function($query){
                $query->where('logistics.code', 'like', '%' .$this->search. '%')
                ->Orwhere('logistics.trf_code', 'like', '%' .$this->search. '%');
            })->where('user_receive', auth()->user()->id)->get();

        return view('livewire.admin.receive-stock.list-receive-stock-component',compact('shipout'))->layout('layouts.base');
    }

    //Receive Detail
    public function receiveDetail($id)
    {
        return redirect(route('admin.detail_receive', $id));
    }

    public function receivePrint($id)
    {
        return redirect(route('admin.print_receive', $id));
    }

}
