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

class ViewEwalletComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $hiddenId,$search,$search_by_name,$search_bran;
    public $acno,$acname,$tr,$branch_id,$ac,$an,$st;
    public $idup,$facno,$facname,$amount=0,$document,$description='Cash In:';

    public function render()
    {

      $branch = Branch::select('branches.id','branches.company_name_la')
                        ->leftJoin('ewallets','branches.id','=','ewallets.branch_id')
                        ->where('ewallets.acno',null)
                        ->where('branches.del',1)->get();

    if(Auth()->user()->branchname->id==1)
    { 
         
        $ewallet=Ewallet::select('ewallets.*','branches.company_name_la as company_name_la','branches.company_name_en as company_name_en') 
                ->join('branches','ewallets.branch_id','=','branches.id') 
                ->where(function($query){
                $query->where('ewallets.acno', 'like', '%' .$this->search. '%');
                })->where('branches.company_name_la', 'like', '%' .$this->search_by_name. '%') ->paginate(15);
    }
    else
    {
        $ewallet=Ewallet::select('ewallets.*','branches.company_name_la as company_name_la','branches.company_name_en as company_name_en') 
                ->join('branches','ewallets.branch_id','=','branches.id') 
                ->where('ewallets.branch_id',Auth()->user()->branchname->id)
                ->where(function($query){
                $query->where('ewallets.acno', 'like', '%' .$this->search. '%');
                })->where('branches.company_name_la', 'like', '%' .$this->search_by_name. '%') ->paginate(15);

    }


     
         
        return view('livewire.admin.ewallet.view-ewallet-component',compact('ewallet','branch'))->layout('layouts.base');
    }

    public function mount()
    {
       // $this->acno =  'AC'.date('Ymdms');
        //$this->tr =  'TR'.date('Ymdms');
    }

    //Reset field CustomerType
    public function resetField()
    {
        $this->acno = $this->acno =  'AC'.date('Ymdms');
        $this->acname = '';
        $this->branch_id='';
    }

    //Validate realtime CustomerType
    protected $rules = [
        'acname'=>'required',
        'branch_id'=>'required'
    ];
    protected $messages = [
        'acname.required'=>'ໃສ່ຊື່ບັນຊີ',
        'branch_id.required'=>'ເລືອກສາຂາ!'
    ];


    //Show and store distance
    public function create()
    {
        $this->resetField();
        $this->dispatchBrowserEvent('show-modal-add');

    }


    public function showAddCalculatePrice()
    {
        $this->resetField();
        $this->dispatchBrowserEvent('show-modal-add-ewallet');
    }
    public function store()
    {
        $this->validate();

        $chekm= DB::table('ewallets')
        ->select(DB::raw('count(id) as c'))
        ->where('status','=','N')
        ->where('branch_id','=',$this->branch_id)
        ->groupBy('branch_id')
        ->first();

        if(!empty($chekm))
        {
            $this->emit('alert', ['type' => 'warning', 'message' => 'ມີບັນຊີເຄື່ອນໄຫວແລ້ວ!']);
        
        }
        else
        {
            $this->tx='TR'.date('ymdHis') . substr(fmod(microtime(true), 1), 2,2);
            $this->rec_tran($this->tx,'EOPN',0,0,0,$this->acno,null,null,Auth()->user()->branchname->id,null,null,'Open account');
            //open account ///
            $addacno = new Ewallet();
            $addacno->acno = $this->acno;
            $addacno->acname = $this->acname;
            $addacno->branch_id = $this->branch_id;
            $addacno->currency_code ='LAK';
            $addacno->balance = 0;
            $addacno->income = 0;
            $addacno->expend =0;
            $addacno->status = 'N';
            $addacno->user_create=auth()->user()->id;
            $addacno->save();

            $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
            $this->resetField();
        }
    }


      //Show and Delete CustomerType
    public function showDestroy($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete');

            $singleData = Ewallet::find($ids);
    
            $this->hiddenId = $singleData->id;
            $this->ac = $singleData->acno;
            $this->an=$singleData->acname;
            $this->st=$singleData->status;

    }

    public function destroy($ids)
    {
       
    
        
           $dropdata = Ewallet::find($ids);
                $chekm= DB::table('ew_stms')
                ->select(DB::raw('count(acno) as c'))
                ->where('acno', $dropdata->acno)
                ->groupBy('acno')
                ->first();

                if(!empty($chekm->c))
                {
                    $this->tx='TR'.date('ymdHis') . substr(fmod(microtime(true), 1), 2,2);
                    if($dropdata->status=='N')
                    {
                        
                        $this->rec_tran($this->tx,'ECLS',0,0,0,$dropdata->acno,null,null,Auth()->user()->branchname->id,null,null,'Close Account');
                        $dropdata->status ='C';
                        $dropdata->save();
                    }
                    else
                    {
    
                        $this->rec_tran($this->tx,'EACT',0,0,0,$dropdata->acno,null,null,Auth()->user()->branchname->id,null,null,'Active Account');
                        $dropdata->status ='N';
                        $dropdata->save();
                    }

                    $this->dispatchBrowserEvent('hide-modal-delete');
                    $this->emit('alert', ['type' => 'success', 'message' => 'ປິດບັນຊີສຳເລັດ!']);
                    $this->resetField();

                }
                else
                {
                    Ewallet::where('acno',$dropdata->acno)->delete();
                    EwTran::where('code1',$dropdata->acno)->delete();
                    $this->dispatchBrowserEvent('hide-modal-delete');
                    $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
                }


             

    }

    public function showCash($ids)
    {
        $this->dispatchBrowserEvent('show-modal-cash');
        $findac = Ewallet::find($ids);
        $this->idup=$findac->id;
        $this->facno=$findac->acno;
        $this->facname=$findac->acname;
    }

    public function recordcash($ids)
    {


        $this->validate([
            'amount' => 'required|numeric|gt:0'
        ],[
            'amount.required'=>'ລະບຸຍອດທຸລະກຳ!'
        ]);

        
        $findac = Ewallet::find($ids);
        if($findac->status!='N')
        {
            $this->emit('alert', ['type' => 'warning', 'message' => 'ສະຖານະບັນຊີເປັນຢຸດການເຄື່ອນໄຫວ ບໍ່ອະນຸຍາດໃຫ້ເຮັດທຸລະກຳ!']);
        }
        else
        {
            $this->tx='TR'.date('ymdHis') . substr(fmod(microtime(true), 1), 2,2);
            $this->rec_tran($this->tx,'ECIN',$this->amount,0,0,$findac->acno,null,$this->document,Auth()->user()->branchname->id,null,null,$this->description);
            $this->rec_stm('ECIN',$ids,$findac->acno,'+',$this->amount,$this->tx,null,null,'ມອບເງິນສົດ');
    
            $findac->balance =$findac->balance + $this->amount; 
            $findac->save();
        
            $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
            $this->dispatchBrowserEvent('hide-modal-cash'); 
            $this->document="";
            $this->amount=0;
        }

    }



    public function rec_tran($txi,$txc,$am1,$am2,$am3,$cd1,$cd2,$cd3,$br,$ur,$rdt,$des)
    {
             // record ew_tran //
            $addtran = new EwTran();
            $addtran->txid=$txi;
            $addtran->txcode=$txc;
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

    public function rec_stm($txd,$eid,$eacno,$act,$amt,$trc,$vc,$mc,$descs)
    {
        // record ew_stm //
        $addstm= new EwStm();
        $addstm->txcode=$txd;
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
