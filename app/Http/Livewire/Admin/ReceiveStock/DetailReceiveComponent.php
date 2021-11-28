<?php

namespace App\Http\Livewire\Admin\ReceiveStock;

use Livewire\Component;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticTransection;
use App\Models\Transaction\ReceiveTransaction;
use App\Models\Transaction\Matterail;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use Carbon\Carbon;
use DB;

class DetailReceiveComponent extends Component
{

    public $receiveCode, $hiddenId;

    public function mount($id)
    {
        $logistic = LogisticDetail::find($id);
        $this->hiddenId = $id;
        $this->receiveCode = $logistic->rvcode;

    }

    public function render()
    {
            $logistic = LogisticDetail::find($this->hiddenId);
            $matterail = Matterail::select('matterails.id as id','matterails.code','matterails.large','matterails.height','matterails.longs','matterails.weigh','matterails.currency_code','matterails.branch_id as branch_id',
                'matterails.amount','matterails.paid_type','goods_types.name as gname','product_types.name as pname')
                ->join('goods_types','matterails.goods_id','=','goods_types.id')
                ->join('product_types','matterails.product_type_id','=','product_types.id')
                ->where('receive_id',  $this->receiveCode)->get();

        return view('livewire.admin.receive-stock.detail-receive-component',compact('matterail','logistic'))->layout('layouts.base');
    }
}
