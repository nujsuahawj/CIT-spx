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

class EwTranComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $hiddenId,$search,$search_by_name,$search_bran;
    public $ac,$tid,$tcod,$tcrdt,$tcur,$tam1,$tam2,$tam3,$tcode1,$tcode2,$tcode3,$brc,$usc,$usr,$dtr,$descs,$acname,$sta,$stm;
    public $myarray=[];
 


    public function render()
    {
        if(Auth()->user()->branchname->id==1)
        {
            $ewtran=EwTran::select('ew_trans.*','br.company_name_la as name_la','br.company_name_en as name_en','uc.name as ucname') 
            ->join('branches as br','ew_trans.branch_id','=','br.id') 
            ->join('users as uc','ew_trans.user_create','=','uc.id')
            ->where(function($query){
            $query->where('ew_trans.txid', 'like', '%' .$this->search. '%')->orwhere('ew_trans.code1', 'like', '%' .$this->search. '%');
            })->where('br.company_name_la', 'like', '%' .$this->search_by_name. '%')->orderby('created_at','desc') ->paginate(10);

        }
        else
        {
            $ewtran=EwTran::select('ew_trans.*','br.company_name_la as name_la','br.company_name_en as name_en','uc.name as ucname') 
            ->join('branches as br','ew_trans.branch_id','=','br.id') 
            ->join('users as uc','ew_trans.user_create','=','uc.id')
            ->where('ew_trans.branch_id',Auth()->user()->branchname->id)
            ->where(function($query){
                $query->where('ew_trans.txid', 'like', '%' .$this->search. '%')->orwhere('ew_trans.code1', 'like', '%' .$this->search. '%');
                })->where('br.company_name_la', 'like', '%' .$this->search_by_name. '%')->orderby('created_at','desc') ->paginate(10);
        }




        return view('livewire.admin.ewallet.ew-tran-component',compact('ewtran'))->layout('layouts.base');
    }

    public function showdestoy($ids)
    {

        $this->dispatchBrowserEvent('show-modal-delete');

           $singleData = EwTran::where('txid',$ids)->first();
    
           $this->hiddenId = $singleData->txid;
           $this->ac = $singleData->txid;

    }

    public function destroy($ids)
    {
        if(Auth()->user()->branchname->id==1)
        {
            $updstm=EwStm::where('trcode',$ids)->first();
            $updbal=Ewallet::where('acno',$updstm->acno)->first();
            if($updbal->status != 'N' )
            {
                    $this->dispatchBrowserEvent('hide-modal-delete');
                    $this->emit('alert', ['type' => 'warning', 'message' => 'ສະຖານະຂອງບັນຊີ ewallet ເປັນຢຸດການເຄື່ອນໄຫວ!']);
            }
            else
            {
                
    
                if($updbal->balance - $updstm->amount<0)
                {
                    $this->dispatchBrowserEvent('hide-modal-delete');
                    $this->emit('alert', ['type' => 'warning', 'message' => 'ຍອດບັນຊີ ewallet ບໍ່ສາມາດເປັນຄ່າລົບໄດ້!']);
                }
                else
                {
                    EwTran::where('txid', '=', $ids)->update(['status' => 'R','user_revert'=>auth()->user()->id,'revertdt'=>date('Y-m-d H:i:s')]);
                    $updstm->status='R';
                    $updstm->save();
                
                    $updbal->balance =$updbal->balance - $updstm->amount; 
                    $updbal->save();
                    $this->dispatchBrowserEvent('hide-modal-delete');
                    $this->emit('alert', ['type' => 'success', 'message' => 'ການຍົກເລີກທຸລະກຳສຳເລັດ!']);
                }
            } 

        }
        else
        {
            $this->emit('alert', ['type' => 'warning', 'message' => 'ທ່ານບໍມີສິດໃນ ການຍົກເລີກທຸລະກຳ!']);
        }
       
               
    }

    public function detail($ids)
    {
        $this->dispatchBrowserEvent('show-modal-detail');
        $stran=EwTran::select('ew_trans.*','br.company_name_la as name_la','br.company_name_en as name_en','uc.name as ucname','ur.name as urname') 
        ->join('branches as br','ew_trans.branch_id','=','br.id') 
        ->join('users as uc','ew_trans.user_create','=','uc.id')
        ->leftJoin('users as ur','ew_trans.user_revert','=','ur.id')->where('txid',$ids)->first();

    
        $this->tid=$stran->txid;
        $this->tcod=$stran->txcode;
        $this->tcrdt=$stran->created_at;
        $this->tcur=$stran->currency_code;
        $this->tam1=$stran->amount1;
        $this->tam2=$stran->amount2;
        $this->tam3=$stran->amount3;
        $this->tcode1=$stran->code1;
        $this->tcode2=$stran->code2;
        $this->tcode3=$stran->code3;
        $this->brc=$stran->name_la;
        $this->usc=$stran->ucname;
        $this->usr=$stran->urname;
        $this->dtr=$stran->revertdt;
        $this->descs=$stran->descs;
        $this->sta=$stran->status;
        $this->acname=$stran->acname;


        $this->myarray =EwStm::select('ew_stms.*','ew.acname as acname')
                        ->join('ewallets as ew','ew_stms.acno','=','ew.acno')
                        ->where('trcode',$stran->txid)->get();

     
    }
}
