<?php

namespace App\Http\Livewire\Admin\ReceiveStock;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticDetailList;
use App\Models\Logistic\LogisticTransection;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\Matterail;
use App\Models\Transaction\CreateTraffic;
use App\Models\Staff\StaffDoing;
use Carbon\Carbon;

class DetailShipoutStockComponent extends Component
{

    protected $paginationTheme = 'bootstrap';

    public $branch_id;

    public $hidenId;

    public function mount($id)
    {
        $this->hidenId = $id;
    }

    public function render()
    {
        $logistic = Logistic::find($this->hidenId);
        $branch = LogisticDetail::where('lgt_id', $logistic->id)->get();
        $matterail = LogisticDetailList::where('lgt_id', $logistic->id)->get();
        // dd($this->hidenId);
        return view('livewire.admin.receive-stock.detail-shipout-stock-component',compact('branch','matterail','logistic'))->layout('layouts.base');
    }
    
}
