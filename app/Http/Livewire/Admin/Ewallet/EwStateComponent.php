<?php

namespace App\Http\Livewire\Admin\Ewallet;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\Transaction\Ewallet;
use App\Models\Transaction\EwTran;
use App\Models\Transaction\EwStm;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use Illuminate\Http\Request;
use DB;

class EwStateComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $hiddenId,$acno,$frdt,$todt,$bal;
    public $myarray=[];
    public $vacno,$vname,$vbr,$vopdt,$endbal,$opnbal;
    public function render()
    {
        $bran=Ewallet::select('acno','acname')->get();
        return view('livewire.admin.ewallet.ew-state-component',compact('bran'))->layout('layouts.base');
    }

    public function search()
    {
    
        if(!empty($this->acno) && !empty($this->frdt) && !empty($this->todt))
        {
                 
               $ew=Ewallet::select('ewallets.acno','ewallets.acname','ewallets.balance','br.company_name_la as brname')
                        ->join('branches as br','ewallets.branch_id','=','br.id')
                        ->where('ewallets.acno',$this->acno)->first();

                    $this->vacno=$ew->acno;
                    $this->vname=$ew->acname;
                    $this->vbr=$ew->brname;
                    $this->bal=$ew->balance;
                $bald=EwStm::where('acno',$this->acno)->where('action','+')->where('status','N')
                            ->where('valuedt','>=',$this->frdt)
                             ->sum('amount');
                $balc=EwStm::where('acno',$this->acno)->where('action','-')->where('status','N')
                             ->where('valuedt','>=',$this->frdt)
                              ->sum('amount');
               $this->opnbal=  $ew->balance+$balc-$bald;
                
                
               $this->myarray=EwStm::select('ew_stms.txcode','ew_stms.valuedt','ew_stms.trcode','ew_stms.action','ew_stms.amount','ew_stms.descs','st.descs as des','us.name as name')
                        ->join('ew_trans as st','ew_stms.trcode','=','st.txid')
                        ->join('users as us','ew_stms.user_create','=','us.id')
                        ->where('ew_stms.status','N')
                        ->where('ew_stms.valuedt','>=',$this->frdt) -> where('ew_stms.valuedt','<=',$this->todt)
                        ->where('ew_stms.acno',$this->acno)
                        ->orderBy('ew_stms.created_at','asc')
                        ->get();



        }
        else
        {
            $this->emit('alert', ['type' => 'warning', 'message' => 'ປ້ອນຂໍ້ມູນໃຫ້ຄົບ!']);
        }
    }
}
