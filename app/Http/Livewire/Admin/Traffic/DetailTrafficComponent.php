<?php

namespace App\Http\Livewire\Admin\Traffic;

use Livewire\Component;
use App\Models\Transaction\ListTraffic;
use App\Models\Transaction\CreateTraffic;
use App\Models\Transaction\ExpTraffic;
use App\Models\Transaction\ExpendType;
use App\Models\Staff\StaffDoing;

class DetailTrafficComponent extends Component
{
    public $hidenId;

    public function mount($id)
    {
        $this->hidenId = $id; 
    }

    public function render()
    {
        $traff = CreateTraffic::find($this->hidenId);
        $expend = ExpendType::where('exp_code', $traff->trf_code)->get();
        $sum_expend = ExpendType::where('exp_code', $traff->trf_code)->sum('amount');
        $staff = StaffDoing::where('trf_code', $traff->trf_code)->get();
        return view('livewire.admin.traffic.detail-traffic-component', compact('traff','expend','staff','sum_expend'))->layout('layouts.base');
    }
}
