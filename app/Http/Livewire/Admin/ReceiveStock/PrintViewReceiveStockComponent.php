<?php

namespace App\Http\Livewire\Admin\ReceiveStock;

use Livewire\Component;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticDetailList;
use App\Models\Logistic\LogisticTransection;
use App\Models\Transaction\ReceiveTransaction;
use App\Models\Transaction\Matterail;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use Carbon\Carbon;
use DB;

class PrintViewReceiveStockComponent extends Component
{

    public $receiveCode, $hiddenId;

    public function mount($id)
    {
        $this->hiddenId = $id;
    }

    public function render()
    {
            $logistic = Logistic::find($this->hiddenId);

            $branch = LogisticDetail::where('lgt_id', $this->hiddenId)->get();

            $matterail = LogisticDetailList::where('lgt_id', $this->hiddenId)->get();

        return view('livewire.admin.receive-stock.print-view-receive-stock-component',compact('branch','matterail','logistic'))->layout('layouts.base');
    }
}
