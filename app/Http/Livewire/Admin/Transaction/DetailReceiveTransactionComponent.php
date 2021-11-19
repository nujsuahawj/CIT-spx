<?php

namespace App\Http\Livewire\Admin\Transaction;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Condition\Customer;
use App\Models\Settings\CustomerType;
use App\Models\Settings\Branch;
use App\Models\Settings\Province;
use App\Models\Settings\District;
use App\Models\Settings\Village;
use App\Models\Settings\GoodsType;
use App\Models\Condition\ProductType;
use App\Models\Settings\CalculatePrice;
use App\Models\Transaction\Matterail;
use App\Models\Transaction\ListMatterail;
use App\Models\Transaction\ReceiveTransaction;
use Illuminate\Http\Request;
use DB;

class DetailReceiveTransactionComponent extends Component
{

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hidenId;

    public function mount($id)
    {
        $this->hidenId = $id;
    }

    public function render()
    {
        $rc_tran = ReceiveTransaction::find($this->hidenId);
        $mat = Matterail::where('receive_id', $rc_tran->code)->get();
        return view('livewire.admin.transaction.detail-receive-transaction-component', compact('rc_tran','mat'))->layout('layouts.base');
    }

    public function showDetail($ids)
    {
        return redirect(route('transaction.detail_receive_transaction',$ids));
    }

    public function receive()
    {
        return redirect(route('transaction.receive'));
    }
}
