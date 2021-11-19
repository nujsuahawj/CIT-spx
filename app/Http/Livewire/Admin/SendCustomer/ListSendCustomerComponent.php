<?php

namespace App\Http\Livewire\Admin\SendCustomer;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\Matterail;
use App\Models\Transaction\ListMatterail;
use App\Models\Transaction\ReceiveTransaction;
use App\Models\Settings\Exchange;
use App\Models\Settings\Branch;
use Illuminate\Http\Request;
use DB;

class ListSendCustomerComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;

    public function render()
    {
        if(!empty($this->search)){
            $receive = ReceiveTransaction::where('branch_receive', auth()->user()->branchname->id)
            ->where('status','SC')->where('code','like','%'.$this->search.'%')->get();
        }else{
            $receive = ReceiveTransaction::where('branch_receive', auth()->user()->branchname->id)
            ->where('status','SC')->get();
        }
        
        return view('livewire.admin.send-customer.list-send-customer-component',compact('receive'))->layout('layouts.base');
    }

    public function DetailReceive($ids)
    {
        return redirect(route('transaction.detail_receive_transaction',$ids));
    }
}
