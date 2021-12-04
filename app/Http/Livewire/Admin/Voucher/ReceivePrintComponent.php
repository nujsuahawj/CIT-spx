<?php

namespace App\Http\Livewire\Admin\Voucher;

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
use Illuminate\Http\Request;
use DB;


class ReceivePrintComponent extends Component
{

    public function render()
    {
        $currentURL = \Request::segment(2);
        $branchid  = Auth()->user()->branchname->id;

        $receive = ReceiveTransaction::where('code', $currentURL)->first();
        $count_mtl = Matterail::select('id')->where('receive_id', $currentURL)->count('id');
                    
        return view('livewire.admin.voucher.receive-print-component',compact('receive','count_mtl'))->layout('layouts.base');
       //return view('livewire.admin.voucher.receive-print-component');
    }
}
