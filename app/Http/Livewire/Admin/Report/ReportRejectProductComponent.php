<?php

namespace App\Http\Livewire\Admin\Report;

use Livewire\Component;
use App\Models\Settings\Branch;
use App\Models\Transaction\ReceiveTransaction;
use Illuminate\Http\Request;
use DB;

class ReportRejectProductComponent extends Component
{
    public $branch_search, $start, $end;

    public $branch_id;

    public function render()
    {
        $branch = Branch::get();
        if(auth()->user()->rolename->name == 'admin'){
            if(!empty(!empty($this->branch_search))){
                if(!empty(!empty($this->start))){
                    if(!empty(!empty($this->end))){
                        $starts_date = $this->start;
                        $ends_date = date('Y-m-d', strtotime($this->end. ' + '. 1 .' days'));
                        $tran = ReceiveTransaction::whereBetween('created_at', [$starts_date,$ends_date])
                        ->where('branch_create_id', $this->branch_search)->where('status','RJ')->get();
                        $sum_amount = ReceiveTransaction::where('branch_id', $this->branch_search)
                        ->whereBetween('created_at', [$starts_date,$ends_date])->where('status','RJ')->sum('amount');
                    }else{ // else end
                        $starts_date = $this->start;
                        $ends_date = date('Y-m-d');
                        $tran = ReceiveTransaction::whereBetween('created_at', [$starts_date,$ends_date])
                        ->where('branch_create_id', $this->branch_search)->where('status','RJ')->get();
                        $sum_amount = ReceiveTransaction::where('branch_create_id', $this->branch_search)
                        ->whereBetween('created_at', [$starts_date,$ends_date])->where('status','RJ')->sum('amount');
                    }
                }else{ //else start
                    $tran = ReceiveTransaction::where('branch_create_id', $this->branch_search)->where('status','RJ')->get();
                    $sum_amount = ReceiveTransaction::where('branch_create_id', $this->branch_search)->where('status','RJ')->sum('amount');
                }
            }else{ // else branch search
                if(!empty(!empty($this->start))){
                    if(!empty(!empty($this->end))){
                        $starts_date = $this->start;
                        $ends_date = date('Y-m-d', strtotime($this->end. ' + '. 1 .' days'));
                        $tran = ReceiveTransaction::whereBetween('created_at', [$starts_date,$ends_date])
                        ->where('status','RJ')->get();
                        $sum_amount = ReceiveTransaction::whereBetween('created_at', [$starts_date,$ends_date])
                        ->where('status','RJ')->sum('amount');
                    }else{ // else end
                        $starts_date = $this->start;
                        $ends_date = date('Y-m-d');
                        $tran = ReceiveTransaction::whereBetween('created_at', [$starts_date,$ends_date])
                        ->where('status','RJ')->get();
                        $sum_amount = ReceiveTransaction::whereBetween('created_at', [$starts_date,$ends_date])
                        ->where('status','RJ')->sum('amount');
                    }
                }else{ //else start
                    $tran = ReceiveTransaction::orderBy('id','desc')->where('status','RJ')->get();
                    $sum_amount = ReceiveTransaction::where('status','RJ')->sum('amount');
                }
            }
        }else{ // else branch Admin
            if(!empty(!empty($this->start))){
                if(!empty(!empty($this->end))){
                    $starts_date = $this->start;
                    $ends_date = date('Y-m-d', strtotime($this->end. ' + '. 1 .' days'));
                    $tran = ReceiveTransaction::whereBetween('created_at', [$starts_date,$ends_date])
                    ->where('branch_create_id', auth()->user()->branchname->id)->where('status','RJ')->get();
                    $sum_amount = ReceiveTransaction::where('branch_create_id', auth()->user()->branchname->id)
                    ->whereBetween('created_at', [$starts_date,$ends_date])->where('status','RJ')->sum('amount');
                }else{ // else end
                    $starts_date = $this->start;
                    $ends_date = date('Y-m-d');
                    $tran = ReceiveTransaction::whereBetween('created_at', [$starts_date,$ends_date])
                    ->where('branch_create_id', auth()->user()->branchname->id)->where('status','RJ')->get();
                    $sum_amount = ReceiveTransaction::where('branch_create_id', auth()->user()->branchname->id)
                    ->whereBetween('created_at', [$starts_date,$ends_date])->where('status','RJ')->sum('amount');
                }
            }else{ //else start
                $tran = ReceiveTransaction::where('branch_create_id', auth()->user()->branchname->id)->where('status','RJ')->get();
                $sum_amount = ReceiveTransaction::where('branch_create_id', auth()->user()->branchname->id)
                ->where('status','RJ')->sum('amount');
            }
        }
        return view('livewire.admin.report.report-reject-product-component', compact('branch','tran','sum_amount'))->layout('layouts.base');
    }
}