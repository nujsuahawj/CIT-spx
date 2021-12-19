<?php

namespace App\Http\Livewire\Admin\Report;

use Livewire\Component;
use App\Models\Transaction\ReceiveTransaction;
use App\Models\Settings\Branch;
use DB;

class ReportShipoutGoods extends Component
{
    public $search, $search_by_date, $search_by_brc=0;

    public function render()
    {
        $branchid  = Auth()->user()->branchname->id;
        if(Auth()->user()->rolename->name == 'admin'){
            $branch = Branch::where('del',1)->get();
            if($this->search_by_brc==0){
                $receivetransaction=ReceiveTransaction::select('receive_transactions.*','bs.company_name_la as brs','br.company_name_la as brr','cs.name as css','cr.name as crr') 
                ->join('branches as bs','receive_transactions.branch_send','=','bs.id')
                ->join('branches as br','receive_transactions.branch_receive','=','br.id')
                ->join('customers as cs','receive_transactions.customer_send','=','cs.id')
                ->join('customers as cr','receive_transactions.customer_receive','=','cr.id')
                ->where(function($query){
                    $query->where('receive_transactions.code', 'like', '%' .$this->search. '%');
                 })->where('receive_transactions.valuedt', 'like', '%' .$this->search_by_date. '%')  
                 ->where('status','=', 'SC')
                ->orderBy('receive_transactions.id','desc')->get();
            }else{
                $receivetransaction=ReceiveTransaction::select('receive_transactions.*','bs.company_name_la as brs','br.company_name_la as brr','cs.name as css','cr.name as crr') 
                ->join('branches as bs','receive_transactions.branch_send','=','bs.id')
                ->join('branches as br','receive_transactions.branch_receive','=','br.id')
                ->join('customers as cs','receive_transactions.customer_send','=','cs.id')
                ->join('customers as cr','receive_transactions.customer_receive','=','cr.id')
                ->where(function($query){
                    $query->where('receive_transactions.code', 'like', '%' .$this->search. '%');
                 })->where('receive_transactions.valuedt', 'like', '%' .$this->search_by_date. '%')
                 ->where('status','=', 'SC')
                 ->orderBy('receive_transactions.id','desc')->get();
            }
        }else{
            $branch = Branch::where('id',$branchid)->get();
            $receivetransaction=ReceiveTransaction::select('receive_transactions.*','bs.company_name_la as brs','br.company_name_la as brr','cs.name as css','cr.name as crr') 
            ->join('branches as bs','receive_transactions.branch_send','=','bs.id')
            ->join('branches as br','receive_transactions.branch_receive','=','br.id')
            ->join('customers as cs','receive_transactions.customer_send','=','cs.id')
            ->join('customers as cr','receive_transactions.customer_receive','=','cr.id')
            ->where('receive_transactions.branch_send','=',$branchid,'or','receive_transactions.branch_receive','=',$branchid)
            ->where(function($query){
                $query->where('receive_transactions.code', 'like', '%' .$this->bch. '%');
             })->where('receive_transactions.valuedt', 'like', '%' .$this->search_by_date. '%')
             ->where('status','=', 'SC')
             ->orderBy('receive_transactions.id','desc')->get();
        }
        return view('livewire.admin.report.report-shipout-goods',compact('branch','receivetransaction'))->layout('layouts.base');
    }
}
