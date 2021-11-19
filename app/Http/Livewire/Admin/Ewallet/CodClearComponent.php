<?php

namespace App\Http\Livewire\Admin\Ewallet;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\Transaction\Ewallet;
use App\Models\Transaction\EwTran;
use App\Models\Transaction\EwStm;
use App\Models\Transaction\CodClear;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use Illuminate\Http\Request;

class CodClearComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $hiddenId,$search,$search_by_name,$search_bran;
    public $hacno,$hacname,$hbalance;
    public $sacno,$sacname,$sbalance;
    public $racno,$racname,$rbalance;
    public $idt,$hqid,$total,$namount,$amount;
    public $idup,$facno,$facname,$ref,$decs='TR to Customer:';

    public $ref1,$ref2,$ms,$mr,$descs='TR to Uinit:';


    public function render()
    {
        

            $listcod=CodClear::select('cod_clears.id as id','cod_clears.valuedt','cod_clears.vcode as vcode','cod_clears.cod_total','bs.company_name_la as bsname','br.company_name_la as brname','cod_clears.clr_dt1',
                        'cod_clears.currency_code','cod_clears.clr_dt2','cod_clears.clr_dt3','cod_clears.status')
                        ->join('branches as bs','cod_clears.branch_send','=','bs.id')
                        ->join('branches as br','cod_clears.branch_recieve','=','br.id')
                        ->where(function($query){
                         $query->where('cod_clears.vcode', 'like', '%' .$this->search. '%') ->orwhere('bs.company_name_la', 'like', '%' .$this->search. '%')
                        ->orwhere('br.company_name_la', 'like', '%' .$this->search. '%');
                         })->paginate(15);
             
       
        return view('livewire.admin.ewallet.cod-clear-component',compact('listcod'))->layout('layouts.base');
    }

    public function transf_customer($ids)
    {
    

        $this->dispatchBrowserEvent('show-modal-trcus');

        $showdata=CodClear::select('cod_clears.id as id','cod_clears.vcode','cod_clears.cod_total','cod_clears.hqid as hid','cod_clears.branch_recieve','hqew.acno as hacno',
        'hqew.balance as hbalance','hqew.acname as hacname')
                          ->join('ewallets as hqew','cod_clears.hqid','=','hqew.branch_id')
                          ->where('cod_clears.id',$ids)
                          ->first();

                $this->hacno=$showdata->hacno;
                $this->hacname=$showdata->hacname;
                $this->hbalance=number_format($showdata->hbalance,2,",",".");
                $this->idt=$showdata->id;
                $this->total = number_format($showdata->cod_total,2,",",".");
                $this->amount= number_format(($showdata->cod_total * 97)/100,2,",",".");
                $this->namount=($showdata->cod_total * 97)/100;
    }

     
    public function clear_income($ids)
    {
        $this->dispatchBrowserEvent('show-modal-clearin');

        $this->ref1='';
        $this->ref2='';
        $this->descs='TR to Uinit:';
        $showdata=CodClear::select('cod_clears.id as id','cod_clears.cod_total','cod_clears.hqid as hid',
                                    'brew.acno as bracno','brew.balance as brbalance','brew.acname as bracname',
                                    'hqew.acno as hacno','hqew.balance as hbalance','hqew.acname as hacname',
                                    'sew.acno as sacno','sew.acname as sacname','sew.balance as sbalance'
                                    )
                          ->join('ewallets as brew','cod_clears.branch_recieve','=','brew.branch_id')
                          ->join('ewallets as hqew','cod_clears.hqid','=','hqew.branch_id')
                          ->join('ewallets as sew','cod_clears.branch_send','=','sew.branch_id')
                          ->where('cod_clears.id',$ids)
                          ->first();

               $this->hacno=$showdata->hacno;
                $this->hacname=$showdata->hacname;
                $this->hbalance=number_format($showdata->hbalance,2,",",".");

                $this->hqid=$showdata->hid;
                $this->idt=$showdata->id;
                $this->total = number_format($showdata->cod_total,2,",",".");
                $this->ms=number_format(($showdata->cod_total * 0.5)/100,2,",",".");
                $this->mr=number_format(($showdata->cod_total * 0.5)/100,2,",",".");


                $this->sacno=$showdata->sacno;
                $this->sacname=$showdata->sacname;
               $this->sbalance=number_format($showdata->sbalance,2,",",".");

                $this->racno=$showdata->bracno;
                $this->racname=$showdata->bracname;
               $this->rbalance=number_format($showdata->brbalance,2,",",".");



    }

    public function clear_cod($ids)
    {
        $this->dispatchBrowserEvent('show-modal-clearcod');

        
        $showdata=CodClear::select('cod_clears.id as id','cod_clears.vcode','cod_clears.cod_total','cod_clears.hqid as hid','cod_clears.branch_recieve','hqew.acno as hacno','hqew.balance as hbalance',
                                   'brew.acno as bracno','brew.balance as brbalance','hqew.acname as hacname','brew.acname as bracname')
                          ->join('ewallets as hqew','cod_clears.hqid','=','hqew.branch_id')
                          ->join('ewallets as brew','cod_clears.hqid','=','brew.branch_id')
                          ->where('cod_clears.id',$ids)
                          ->first();

                $this->hacno=$showdata->hacno;
                $this->hacname=$showdata->hacname;
                $this->hbalance=number_format($showdata->hbalance,2,",",".");
                $this->racno=$showdata->rcanco;
                $this->racname=$showdata->bracname;
                $this->rbalance=number_format($showdata->brbalance,2,",",".");
                $this->hqid=$showdata->hid;
                $this->idt=$showdata->id;

                $this->total = number_format($showdata->cod_total,2,",",".");
                $this->amount= number_format($showdata->cod_total,2,",",".");
                $this->namount=$showdata->cod_total;



    }

    public function rectr_cus($ids)
    {
       

            $getcod=CodClear::find($ids);
            $getwall=Ewallet::select('id','acno','balance')->where('branch_id',Auth()->user()->branchname->id)->where('status','N') ->first();

            if( $getcod->status==1)
            {
                    if($getcod->cod_total<=$getwall->balance)
                    {
                        $this->tx='TR'.date('ymdHis') . substr(fmod(microtime(true), 1), 2,2);
                        $this->rec_tran('ECTR',$this->tx,$this->namount,0,0, $getcod->vcode,null,$this->ref,Auth()->user()->branchname->id,null,null,$this->decs);
                        $this->rec_stm('ECTR', $getwall->id,$getwall->acno,'-',$this->namount,$this->tx ,$getcod->vcode,null,'ໂອນຄ່າເຄື່ອງໃຫ້ຮ້ານ');
        
                        $getcod->clr_dt1=date('ymdHis');
                        $getcod->status=2;
                        $getcod->save();
        
                        $getwall->balance=$getwall->balance-$this->namount;
                        $getwall->expend=$getwall->expend+$this->namount;
                        $getwall->save();
        
                        $this->dispatchBrowserEvent('hide-modal-trcus');
                        $this->emit('alert', ['type' => 'success', 'message' => 'ການໂອນສຳເລັດ!']);
                    }
                    else
                    {
                        $this->dispatchBrowserEvent('hide-modal-trcus');
                        $this->emit('alert', ['type' => 'warning', 'message' => 'ຍອດເງິນໃນບັນຊີບໍ່ພໍ!']);
                    }
            }
            else{
                         $this->dispatchBrowserEvent('hide-modal-clearcod');
                        $this->emit('alert', ['type' => 'warning', 'message' => 'ສະຖະລາຍການໂອນບໍ່ຖືກຕ້ອງ!']);
            }
            


    }

    public function rec_income($ids)
    {
        $showdata=CodClear::select('cod_clears.id as id','cod_clears.vcode','cod_clears.status','cod_clears.cod_total','cod_clears.hqid as hid',
                                    'brew.id as brid','brew.acno as bracno','brew.balance as brbalance','brew.acname as bracname',
                                    'hqew.id as hqid','hqew.acno as hacno','hqew.balance as hbalance','hqew.acname as hacname',
                                    'sew.id as sid','sew.acno as sacno','sew.acname as sacname','sew.balance as sbalance'
                                    )
                ->join('ewallets as sew','cod_clears.branch_send','=','sew.branch_id')
                ->join('ewallets as brew','cod_clears.branch_recieve','=','brew.branch_id')
                ->join('ewallets as hqew','cod_clears.hqid','=','hqew.branch_id')
              
                ->where('cod_clears.id',$ids)
                ->first();
        
         if($showdata->status==2)
         {
            if($showdata->hbalance>=($showdata->cod_total)/100)
            {
                $this->tx='TR'.date('ymdHis') . substr(fmod(microtime(true), 1), 2,2);
               

                if($showdata->hqid==$showdata->sid)
                {
                    $this->rec_tran('EUTR',$this->tx,($showdata->cod_total*0.5)/100,0,($showdata->cod_total*0.5)/100, $showdata->vcode,$this->ref1,$this->ref2,Auth()->user()->branchname->id,null,null,$this->descs);
                    $this->rec_stm('EUTR', $showdata->hqid,$showdata->hacno,'-',($showdata->cod_total*0.5)/100,$this->tx ,$showdata->vcode,null,'ປັນຜົນCOD');
                    $this->rec_stm('EUTR', $showdata->brid,$showdata->bracno,'+',($showdata->cod_total*0.5)/100,$this->tx ,$showdata->vcode,null,'ປັນຜົນCOD');

                    $gethq=Ewallet::find( $showdata->hqid);
                    $gethq->balance=$gethq->balance-($showdata->cod_total*0.5)/100;
                    $gethq->expend=$gethq->expend+($showdata->cod_total*0.5)/100;
                    $gethq->save();
    
                    $getbr=Ewallet::find( $showdata->brid);
                    $getbr->balance=$getbr->balance+($showdata->cod_total*0.5)/100;
                    $getbr->income=$getbr->income+($showdata->cod_total*0.5)/100;
                    $getbr->save();
                   
                }
                elseif($showdata->hqid==$showdata->brid)
                {
                    $this->rec_tran('EUTR',$this->tx,($showdata->cod_total*0.5)/100,($showdata->cod_total*0.5)/100,0, $showdata->vcode,$this->ref1,$this->ref2,Auth()->user()->branchname->id,null,null,$this->descs);
                    $this->rec_stm('EUTR', $showdata->hqid,$showdata->hacno,'-',($showdata->cod_total*0.5)/100,$this->tx ,$showdata->vcode,null,'ປັນຜົນCOD');
                    $this->rec_stm('EUTR', $showdata->sid,$showdata->sacno,'+',($showdata->cod_total*0.5)/100,$this->tx ,$showdata->vcode,null,'ປັນຜົນCOD');

                    $gethq=Ewallet::find( $showdata->hqid);
                    $gethq->balance=$gethq->balance-($showdata->cod_total*0.5)/100;
                    $gethq->expend=$gethq->expend+($showdata->cod_total*0.5)/100;
                    $gethq->save();

                    $gets=Ewallet::find( $showdata->sid);
                    $gets->balance=$gets->balance+($showdata->cod_total*0.5)/100;
                    $gets->income=$gets->income+($showdata->cod_total*0.5)/100;
                    $gets->save();


                }
                else
                {
                    $this->rec_tran('EUTR',$this->tx,($showdata->cod_total)/100,($showdata->cod_total*0.5)/100,($showdata->cod_total*0.5)/100, $showdata->vcode,$this->ref1,$this->ref2,Auth()->user()->branchname->id,null,null,$this->descs);
                    $this->rec_stm('EUTR', $showdata->hqid,$showdata->hacno,'-',($showdata->cod_total)/100,$this->tx ,$showdata->vcode,null,'ປັນຜົນCOD');
                    $this->rec_stm('EUTR', $showdata->brid,$showdata->bracno,'+',($showdata->cod_total*0.5)/100,$this->tx ,$showdata->vcode,null,'ປັນຜົນCOD');
                    $this->rec_stm('EUTR', $showdata->sid,$showdata->sacno,'+',($showdata->cod_total*0.5)/100,$this->tx ,$showdata->vcode,null,'ປັນຜົນCOD');
    
                    $gethq=Ewallet::find( $showdata->hqid);
                    $gethq->balance=$gethq->balance-($showdata->cod_total)/100;
                    $gethq->expend=$gethq->expend+($showdata->cod_total)/100;
                    $gethq->save();
    
                    $getbr=Ewallet::find( $showdata->brid);
                    $getbr->balance=$getbr->balance+($showdata->cod_total*0.5)/100;
                    $getbr->income=$getbr->income+($showdata->cod_total*0.5)/100;
                    $getbr->save();
    
                    $gets=Ewallet::find( $showdata->sid);
                    $gets->balance=$gets->balance+($showdata->cod_total*0.5)/100;
                    $gets->income=$gets->income+($showdata->cod_total*0.5)/100;
                    $gets->save();

                }

                



          
                $showdata->clr_dt2=date('ymdHis');
                $showdata->status=3;
                $showdata->save();

                $this->dispatchBrowserEvent('hide-modal-clearin');
                $this->emit('alert', ['type' => 'success', 'message' => 'ການໂອນສຳເລັດ!']);
            }
            else
            {
                $this->dispatchBrowserEvent('hide-modal-clearin');
                $this->emit('alert', ['type' => 'warning', 'message' => 'ຍອດເງິນໃນບັນຊີບໍ່ພໍ!']);

            }

         }
         else
         {
            $this->dispatchBrowserEvent('hide-modal-clearin');
            $this->emit('alert', ['type' => 'warning', 'message' => 'ສະຖານະພາບລາຍການບໍ່ຖືກຕ້ອງ!']);
         }
            

    }

    public function rec_tran($txc,$txid,$am1,$am2,$am3,$cd1,$cd2,$cd3,$br,$ur,$rdt,$des)
    {
             // record ew_tran //
            $addtran = new EwTran();
            $addtran->txcode=$txc;
            $addtran->txid=$txid;    
            $addtran->valuedt=date('Y-m-d');
            $addtran->currency_code='LAK';
            $addtran->amount1=$am1;
            $addtran->amount2=$am2;
            $addtran->amount3=$am3;
            $addtran->code1=$cd1;
            $addtran->code2=$cd2;
            $addtran->code3=$cd3;
            $addtran->user_create=auth()->user()->id;
            $addtran->branch_id= $br;
            $addtran->user_revert=$ur;
            $addtran->revertdt=$rdt;
            $addtran->status='N';
            $addtran->descs=$des;
            $addtran->save();
    }

    public function rec_stm($tx,$eid,$eacno,$act,$amt,$trc,$vc,$mc,$descs)
    {
        // record ew_stm //
        $addstm= new EwStm();
        $addstm->txcode=$tx;
        $addstm->valuedt=date('Y-m-d');
        $addstm->ewid=$eid;
        $addstm->acno=$eacno;
        $addstm->currency_code='LAK';
        $addstm->action=$act;
        $addstm->amount=$amt;
        $addstm->trcode=$trc;
        $addstm->vcode=$vc;
        $addstm->mcode=$mc;
        $addstm->status='N';
        $addstm->descs=$descs;
        $addstm->branch_id=Auth()->user()->branchname->id;
        $addstm->user_create=auth()->user()->id;
        $addstm->save();

    }

}



