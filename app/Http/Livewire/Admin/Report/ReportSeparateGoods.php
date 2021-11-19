<?php

namespace App\Http\Livewire\Admin\Report;

use Livewire\Component;
use App\Models\Transaction\CreateTraffic;
use App\Models\Transaction\Matterail;
use App\Models\Logistic\LogisticDetailList;
use Illuminate\Support\Facades\Auth;
use DB;

class ReportSeparateGoods extends Component
{

    public $vhcl_id, $search, $condition;

    public function render()
    {
        $traff_vhcl = CreateTraffic::where('status', 'S')->orderBy('id','desc')->get();
        $mat = LogisticDetailList::where('status', 'S')->get();
        if(!empty($this->vhcl_id)){
            if($this->condition == 0){
                if(!empty($this->search)){
                    $mat = LogisticDetailList::where('trf_code',$this->vhcl_id)->where('weigh','<',$this->search)->where('status', 'S')->get();
                }
            }elseif($this->condition == 1){ //else condition 1
                if(!empty($this->search)){
                    $mat = LogisticDetailList::where('trf_code',$this->vhcl_id)->where('weigh','>=',$this->search)->where('status', 'S')->get();
                }
            }else{ //else condition
                if(!empty($this->search)){
                    $mat = LogisticDetailList::where('trf_code',$this->vhcl_id)->where('status', 'S')->get();
                }
            }
        }else{ //else vhcl
            if($this->condition == 0){
                if(!empty($this->search)){
                    $mat = LogisticDetailList::where('weigh','<',$this->search)->where('status', 'S')->get();
                }
            }elseif($this->condition == 1){ //else condition 1
                if(!empty($this->search)){
                    $mat = LogisticDetailList::where('weigh','>=',$this->search)->where('status', 'S')->get();
                }
            }else{ //else condition
                    $mat = LogisticDetailList::where('status', 'S')->get();
                }
            }
            
        
        return view('livewire.admin.report.report-separate-goods',compact('traff_vhcl','mat'))->layout('layouts.base');
    }
}
