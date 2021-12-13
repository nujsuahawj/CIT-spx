<?php

namespace App\Http\Livewire\Admin\PayDevidend;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Transaction\Paydevidends;
use App\Models\Transaction\Ewallet;
use App\Models\Transaction\EwTran;
use App\Models\Transaction\EwStm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaction\Matterail;
use App\Models\Settings\Branch;
use Carbon\Carbon;
use DB;

class PayDevidendComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public $search, $hiddenId;

    public function render()
    {
        if(!empty($this->search)){
            $myarray = EwStm::select('ew_stms.*','ew.acname as acname')
            ->join('ewallets as ew','ew_stms.acno','=','ew.acno')
            ->where('ew.branch_id',auth()->user()->branchname->id)
            ->where('ew_stms.descs', 'ເງິນປັນຜົນຄ່າຂົນສົ່ງ')->where('ew_stms.valuedt',$this->search)->paginate(10);

            $sum_myarray = EwStm::select('ew_stms.*','ew.acname as acname')
            ->join('ewallets as ew','ew_stms.acno','=','ew.acno')
            ->where('ew.branch_id',auth()->user()->branchname->id)
            ->where('ew_stms.descs', 'ເງິນປັນຜົນຄ່າຂົນສົ່ງ')->where('ew_stms.valuedt',$this->search)->sum('ew_stms.amount');
        }else{
            $myarray = EwStm::select('ew_stms.*','ew.acname as acname')
            ->join('ewallets as ew','ew_stms.acno','=','ew.acno')
            ->where('ew.branch_id',auth()->user()->branchname->id)
            ->where('ew_stms.descs', 'ເງິນປັນຜົນຄ່າຂົນສົ່ງ')->paginate(10);

            $sum_myarray = EwStm::select('ew_stms.*','ew.acname as acname')
            ->join('ewallets as ew','ew_stms.acno','=','ew.acno')
            ->where('ew.branch_id',auth()->user()->branchname->id)
            ->where('ew_stms.descs', 'ເງິນປັນຜົນຄ່າຂົນສົ່ງ')->sum('ew_stms.amount');
        }
        
        return view('livewire.admin.pay-devidend.pay-devidend-component',compact('myarray','sum_myarray'))->layout('layouts.base');
    }

}
