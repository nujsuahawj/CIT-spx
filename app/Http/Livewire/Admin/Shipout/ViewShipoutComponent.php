<?php

namespace App\Http\Livewire\Admin\Shipout;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticTransection;
use App\Models\Transaction\ReceiveTransaction;
use App\Models\Transaction\Matterail;
use App\Models\Transaction\CreateTraffic;
use App\Models\Transaction\ExpTraffic;
use App\Models\Transaction\ExpendType;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use Carbon\Carbon;

class ViewShipoutComponent extends Component
{
    public $code, $search;
    public $hiddenIdLgt;

    public function render()
    {
        $shipout = Logistic::orderBy('id','desc')->where('branch_id', auth()->user()->branchname->id)->where(function($query){
            $query->where('code', 'like', '%' .$this->search. '%')
            ->Orwhere('trf_code', 'like', '%' .$this->search. '%');
        })->get();
        return view('livewire.admin.shipout.view-shipout-component',compact('shipout'))->layout('layouts.base');
    }

    public function editShipout($ids)
    {
        return redirect(route('admin.edit_shipout',$ids));
    }
    public function showDestroy($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = Logistic::find($ids);
        $this->hiddenIdLgt = $ids;
        $this->code = $singleData->code;
    }
    public function destroy($ids)
    {
        $this->dispatchBrowserEvent('hide-modal-delete');
        $singleData = Logistic::find($ids);
        $detail = LogisticDetail::where('lgt_id', $ids)->delete();
        $singleData->delete();
        $this->emit('alert', ['type' => 'success', 'message' => 'ລົບລາຍການສຳເລັດ!']);
    }
    //Logistic Detail
    public function logisticDetail($id)
    {
        return redirect(route('admin.detail_shipout', $id));
    }
}
