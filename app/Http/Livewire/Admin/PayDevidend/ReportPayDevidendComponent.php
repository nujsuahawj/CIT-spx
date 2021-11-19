<?php

namespace App\Http\Livewire\Admin\PayDevidend;

use Livewire\Component;
use App\Models\Transaction\Paydevidends;
use App\Models\Transaction\Matterail;
use App\Models\Settings\Branch;
use Carbon\Carbon;
use DB;

class ReportPayDevidendComponent extends Component
{

    public $hidenId;

    public function mount($id)
    {
        $this->hidenId = $id;
    }
    public function render()
    {
        $pay = Paydevidends::find($this->hidenId);
        return view('livewire.admin.pay-devidend.report-pay-devidend-component',compact('pay'))->layout('layouts.base');
    }
}
