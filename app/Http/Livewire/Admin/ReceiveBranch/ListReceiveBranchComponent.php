<?php

namespace App\Http\Livewire\Admin\ReceiveBranch;

use Livewire\Component;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticTransection;
use App\Models\Transaction\CreateTraffic;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use Carbon\Carbon;
use DB;

class ListReceiveBranchComponent extends Component
{

    public $search, $code;

    public function render()
    {

        $shipout =LogisticDetail::where('branch_id', auth()->user()->branchname->id)
            ->where(function($query){
                $query->where('rvcode', 'like', '%' .$this->search. '%');
            })->where('status', 'F')->get();

        return view('livewire.admin.receive-branch.list-receive-branch-component',compact('shipout'))->layout('layouts.base');
    }

    //Receive Detail
    public function receiveDetail($id)
    {
        return redirect(route('admin.detail_receive_branch', $id));
    }

    public function receivePrint($id)
    {
        return redirect(route('admin.print_receive_branch', $id));
    }
}
