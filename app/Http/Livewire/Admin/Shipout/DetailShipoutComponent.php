<?php

namespace App\Http\Livewire\Admin\Shipout;

use Livewire\Component;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticDetailList;
use App\Models\Logistic\LogisticTransection;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\Matterail;
use App\Models\Transaction\CreateTraffic;
use App\Models\Staff\StaffDoing;
use Carbon\Carbon;

class DetailShipoutComponent extends Component
{
    protected $paginationTheme = 'bootstrap';

    public $branch_id;

    public $hidenId;

    public function mount($id)
    {
        $logistic = Logistic::find($id);
        $this->hidenId = $logistic->id;
    }

    public function render()
    {
        $logistic = Logistic::find($this->hidenId);
        $branch = LogisticDetail::where('lgt_id', $logistic->id)->get();
        $matterail = LogisticDetailList::where('lgt_id', $logistic->id)->get();
        return view('livewire.admin.shipout.detail-shipout-component',compact('branch','matterail','logistic'))->layout('layouts.base');
    }


}
