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
        $shipout = LogisticDetail::where('branch_id', auth()->user()->branchname->id)->where('status', 'ST')->get();

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
