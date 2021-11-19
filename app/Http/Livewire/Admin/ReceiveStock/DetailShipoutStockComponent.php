<?php

namespace App\Http\Livewire\Admin\ReceiveStock;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticTransection;
use App\Models\Transaction\CreateTraffic;
use DB;

class DetailShipoutStockComponent extends Component
{
    public function render()
    {
        
        return view('livewire.admin.receive-stock.detail-shipout-stock-component')->layout('layouts.base');
    }
}
