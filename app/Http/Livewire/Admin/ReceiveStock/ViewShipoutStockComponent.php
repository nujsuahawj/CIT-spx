<?php

namespace App\Http\Livewire\Admin\ReceiveStock;

use Livewire\Component;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticTransection;
use App\Models\Transaction\CreateTraffic;
use DB;

class ViewShipoutStockComponent extends Component
{

    public $code;

    public $hidenId, $hiddenIdLgt;

    public function render()
    {
        $shipout = Logistic::orderBy('id','desc')->where('branch_id', auth()->user()->branchname->id)->where(function($query){
            $query->where('code', 'like', '%' .$this->code. '%')
            ->Orwhere('trf_code', 'like', '%' .$this->code. '%');
        })->get();

        return view('livewire.admin.receive-stock.view-shipout-stock-component',compact('shipout'))->layout('layouts.base');
    }
}
