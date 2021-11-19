<?php

namespace App\Http\Livewire\Admin\Shipout;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticDetailList;
use App\Models\Logistic\LogisticTransection;
use App\Models\Transaction\ReceiveTransaction;
use App\Models\Transaction\Matterail;
use App\Models\Transaction\CreateTraffic;
use App\Models\Transaction\ExpendType;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use Carbon\Carbon;

class SubShipoutComponent extends Component
{
    public $search;

    public function render()
    {
        $matterails = LogisticDetailList::where('branch_id', auth()->user()->branchname->id)
        ->where(function($query){
            $query->where('code', 'like', '%' .$this->search. '%')
            ->Orwhere('rvcode', 'like', '%' .$this->search. '%');
        })->get();

        return view('livewire.admin.shipout.sub-shipout-component',compact('matterails'))->layout('layouts.base');
    }
}
