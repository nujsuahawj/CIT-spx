<?php

namespace App\Http\Livewire\Admin\SendCustomer;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\Matterail;
use App\Models\Transaction\ListMatterail;
use App\Models\Transaction\ReceiveTransaction;
use App\Models\Transaction\Ewallet;
use App\Models\Transaction\EwStm;
use App\Models\Transaction\EwTran;
use App\Models\Transaction\CodClear;
use App\Models\Settings\Exchange;
use App\Models\Settings\Branch;
use Illuminate\Http\Request;
use DB;

class SendCustomerComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $code, $hidenId;

    public function render()
    {
        $branchid = ''; $vch = ''; $mtl = ''; $ex = ''; $branch = ''; $count_product = ''; $sum_product= '';
        if(!empty($this->code)){
            $receive = ReceiveTransaction::where('branch_receive', auth()->user()->branchname->id)
            ->where('code', $this->code)->get();
        }else{
            $receive = ReceiveTransaction::where('branch_receive', auth()->user()->branchname->id)
            ->where('status', 'F')->get();
        }
        

        if(!empty($this->hidenId)){
            $id = ReceiveTransaction::find($this->hidenId);
            // dd($this->hidenId);
            $branchid  = $id->branch_send;
            $mtl=Matterail::where('receive_id', $id->code)->get();
            $branch = Branch::where('id','=',$branchid)->first();
        }
        return view('livewire.admin.send-customer.send-customer-component',compact('receive','mtl','branch'))->layout('layouts.base');
    }

    public function send($ids)
    {
        $this->dispatchBrowserEvent('show-modal-detail');
        $this->hidenId = $ids;
    }

    public function confirm($ids)
    {
        $receive = ReceiveTransaction::find($ids);
        // $s_paid=0; $r_paid=0;
        // if ($receive->paid_by == 'SD')
        // {
        //     $this->s_paid=$receive->amount + $receive->insur_amount;
        //     if($receive->service_type=='COD'){ $this->r_paid=$receive->cod_amount; } else{$this->r_paid=0;}

        // }else
        // {
        //     $this->s_paid=$receive->insur_amount;
        //     if($receive->service_type=='COD'){ $this->r_paid= $receive->amount + $receive->cod_amount; } else{$this->r_paid= $receive->amount;}

        // }

        // $gethq=Ewallet::where( 'branch_id', 1 )->first();
        // $getsd=Ewallet::where( 'branch_id',  $receive->branch_send)->first();
        // $getbr=Ewallet::where( 'branch_id',  $receive->branch_receive)->first();

        //     if(  ($receive->branch_send != 1) && ($receive->branch_receive==1) )
        //     {
        //         if($this->s_paid >=  $getsd->balance)
        //         {
                    $list_mat = DB::table('list_matterails')->where('rvcode', $receive->code)->update(array('paid_type'=>'SD','status'=>'SC'));
                    $mat = DB::table('matterails')->where('receive_id', $receive->code)->update(array('paid_type'=>'SD','status'=>'SC'));      
                    $receive->deliver_id = auth()->user()->id;
                    $receive->deliver_date = date('Y-m-d h:i:s');
                    $receive->status = 'SC';
                    $receive->save();

            //         $this->tx='TR'.date('ymdHis') . substr(fmod(microtime(true), 1), 2,2);
            //         $this->rec_tran('EHTR', $this->tx , $this->s_paid,0,0,$receive->code,null,null, Auth()->user()->branchname->id ,null,null,'ຊຳລະສະສ້າງລະຫວ່າງໜ່ວຍ ແລະ ສຳນັກງານໃຫຍ່');
            //         if($receive->service_type=='COD')
            //         {
            //              /// Q Ewllate Clearing ///
            //              $this->rec_qcod($receive->code,$receive->cod_amount,1,$receive->branch_send,1);
            //         }
            //         if($receive->insur=='1')
            //         {
            //             $this->rec_stm('EHTR', $getsd->id , $getsd->acno ,'-', $receive->insur_amount , $this->tx ,$receive->code,null,'ຄ່າປະກັນໄພ'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', $receive->insur_amount , $this->tx ,$receive->code,null,'ຄ່າປະກັນໄພ'); 
            //         }                   
            //         if ($receive->paid_by == 'SD')
            //         {
                       
            //             $this->rec_stm('EHTR', $getsd->id , $getsd->acno ,'-', $receive->amount , $this->tx ,$receive->code,null,'ຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', $receive->amount , $this->tx ,$receive->code,null,'ຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'-', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $getsd->id , $getsd->acno ,'+', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $getsd->id , $getsd->acno ,'-', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 
                        
            //         }
            //         else
            //         {
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'-', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $getsd->id , $getsd->acno ,'+', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $getsd->id , $getsd->acno ,'-', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 
            //         }

            //         $getsd->balance=$getsd->balance - $this->s_paid + ( $receive->amount * 0.15 ) - (($receive->amount * 0.15) * 0.05);
            //         $getsd->income=$getsd->income + ( $receive->amount * 0.15 );
            //         $getsd->expend=$getsd->expend + $this->s_paid + (($receive->amount * 0.15) * 0.05) ;
            //         $getsd->save();

            //         $gethq->balance = $gethq -> balance + $this->s_paid - ($receive->amount * 0.15) + (($receive->amount * 0.15) * 0.05) ;
            //         $gethq->income  = $gethq -> income + $this->s_paid + (($receive->amount * 0.15) * 0.05);
            //         $gethq->expend = $gethq->expend + ($receive->amount * 0.15);
            //         $gethq->save();

            //         $this->dispatchBrowserEvent('hide-modal-detail');
            //         $this->emit('alert', ['type' => 'success', 'message' => 'ເບິກເຄື່ອງໃຫ້ລູກຄ້າສຳເລັດ!']);

            //     }
            //     else
            //     {            
            //         $this->emit('alert', ['type' => 'warning', 'message' => 'ຍອດເງິນໃນບັນຊີຂອງໜ່ວຍຕົ່ນທາງ ບໍ່ພຽງພໍກັບການເຮັດທຸລະກໍ!']);
            //     }
 
            
            // }
            // elseif(($receive->branch_send == 1) &&  ($receive->branch_receive!=1))
            // {
            //      if($getbr->balance >= $this->r_paid)
            //      {
            //         $list_mat = DB::table('list_matterails')->where('rvcode', $receive->code)->update(array('paid_type'=>'SD','status'=>'SC'));
            //         $mat = DB::table('matterails')->where('receive_id', $receive->code)->update(array('paid_type'=>'SD','status'=>'SC'));      
            //         $receive->deliver_id = auth()->user()->id;
            //         $receive->deliver_date = date('Y-m-d h:i:s');
            //         $receive->status = 'SC';
            //         $receive->save();

            //         $this->tx='TR'.date('ymdHis') . substr(fmod(microtime(true), 1), 2,2);
            //         $this->rec_tran('EHTR', $this->tx , $this->r_paid,0,0,$receive->code,null,null, Auth()->user()->branchname->id ,null,null,'ຊຳລະສະສ້າງລະຫວ່າງໜ່ວຍ ແລະ ສຳນັກງານໃຫຍ່');

            //         if($receive->service_type=='COD')
            //         {
            //              /// Q Ewllate Clearing ///
            //              $this->rec_qcod($receive->code,$receive->cod_amount,1,1,$receive->branch_receive);
            //              $this->rec_stm('EHTR', $getbr->id , $getbr->acno ,'-', $receive->cod_amount , $this->tx ,$receive->code,null,'ຄ່າເຄື່ອງCOD'); 
            //              $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', $receive->cod_amount , $this->tx ,$receive->code,null,'ຄ່າເຄື່ອງCOD'); 
                       
            //         }

            //         if ($receive->paid_by == 'SD')
            //         {
                       
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'-', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $getbr->id , $getbr->acno ,'+', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $getbr->id , $getbr->acno ,'-', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 
                        
            //         }
            //         else
            //         {
            //             $this->rec_stm('EHTR', $getbr->id , $getbr->acno ,'-', $receive->amount , $this->tx ,$receive->code,null,'ຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', $receive->amount , $this->tx ,$receive->code,null,'ຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'-', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $getbr->id , $getbr->acno ,'+', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $getbr->id , $getbr->acno ,'-', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 
            //         }
                    
            //         $gethq->balance = $gethq -> balance + $this->r_paid - ($receive->amount * 0.15) + (($receive->amount * 0.15) * 0.05) ;
            //         $gethq->income  = $gethq -> income + $this->r_paid + (($receive->amount * 0.15) * 0.05);
            //         $gethq->expend = $gethq->expend + ($receive->amount * 0.15);
            //         $gethq->save();

            //         $getbr->balance=$getbr->balance - $this->r_paid + ( $receive->amount * 0.15 ) - (($receive->amount * 0.15) * 0.05);
            //         $getbr->income=$getbr->income + ( $receive->amount * 0.15 );
            //         $getbr->expend=$getbr->expend + $this->r_paid + (($receive->amount * 0.15) * 0.05) ;
            //         $getbr->save();

            //         $this->dispatchBrowserEvent('hide-modal-detail');
            //         $this->emit('alert', ['type' => 'success', 'message' => 'ເບິກເຄື່ອງໃຫ້ລູກຄ້າສຳເລັດ!']);

            //      }
            //      else
            //      {
            //         $this->emit('alert', ['type' => 'warning', 'message' => 'ຍອດເງິນໃນບັນຊີຂອງໜ່ວຍປາຍທາງ ບໍ່ພຽງພໍກັບການເຮັດທຸລະກໍ!']);
            //      }
            // } 
            // else
            // {
            //     if(($getsd->balance>=$this->s_paid) && ($getbr->balance >=$this->r_paid))
            //     {
            //         $list_mat = DB::table('list_matterails')->where('rvcode', $receive->code)->update(array('paid_type'=>'SD','status'=>'SC'));
            //         $mat = DB::table('matterails')->where('receive_id', $receive->code)->update(array('paid_type'=>'SD','status'=>'SC'));      
            //         $receive->deliver_id = auth()->user()->id;
            //         $receive->deliver_date = date('Y-m-d h:i:s');
            //         $receive->status = 'SC';
            //         $receive->save();

            //         $this->tx='TR'.date('ymdHis') . substr(fmod(microtime(true), 1), 2,2);
            //         $this->rec_tran('EHTR', $this->tx , $this->s_paid + $this->r_paid,0,0,$receive->code,null,null, Auth()->user()->branchname->id ,null,null,'ຊຳລະສະສ້າງລະຫວ່າງໜ່ວຍ ແລະ ສຳນັກງານໃຫຍ່');

            //         if($receive->service_type=='COD')
            //         {
            //              /// Q Ewllate Clearing ///
            //              $this->rec_qcod($receive->code,$receive->cod_amount,1,$receive->branch_send,$receive->branch_receive);
            //              $this->rec_stm('EHTR', $getbr->id , $getbr->acno ,'-', $receive->cod_amount , $this->tx ,$receive->code,null,'ຄ່າເຄື່ອງCOD'); 
            //              $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', $receive->cod_amount , $this->tx ,$receive->code,null,'ຄ່າເຄື່ອງCOD');          
            //         }

            //         if($receive->insur=='1')
            //         {
            //             $this->rec_stm('EHTR', $getsd->id , $getsd->acno ,'-', $receive->insur_amount , $this->tx ,$receive->code,null,'ຄ່າປະກັນໄພ'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', $receive->insur_amount , $this->tx ,$receive->code,null,'ຄ່າປະກັນໄພ'); 
            //         }    

            //         if ($receive->paid_by == 'SD')
            //         {
            //             $this->rec_stm('EHTR', $getsd->id , $getsd->acno ,'-', $receive->amount , $this->tx ,$receive->code,null,'ຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', $receive->amount , $this->tx ,$receive->code,null,'ຄ່າຂົນສົ່ງ');

            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'-', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $getsd->id , $getsd->acno ,'+', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 

            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'-', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $getbr->id , $getbr->acno ,'+', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 

            //             $this->rec_stm('EHTR', $getsd->id , $getsd->acno ,'-', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 

            //             $this->rec_stm('EHTR', $getbr->id , $getbr->acno ,'-', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 
                        
            //         }
            //         else
            //         {
            //             $this->rec_stm('EHTR', $getbr->id , $getbr->acno ,'-', $receive->amount , $this->tx ,$receive->code,null,'ຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', $receive->amount , $this->tx ,$receive->code,null,'ຄ່າຂົນສົ່ງ'); 

            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'-', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $getsd->id , $getsd->acno ,'+', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 

            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'-', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 
            //             $this->rec_stm('EHTR', $getbr->id , $getbr->acno ,'+', $receive->amount * 0.15 , $this->tx ,$receive->code,null,'ເງິນປັນຜົນຄ່າຂົນສົ່ງ'); 

            //             $this->rec_stm('EHTR', $getsd->id , $getsd->acno ,'-', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 

            //             $this->rec_stm('EHTR', $getbr->id , $getbr->acno ,'-', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 
            //             $this->rec_stm('EHTR', $gethq->id , $gethq->acno ,'+', ($receive->amount * 0.15) * 0.05 , $this->tx ,$receive->code,null,'ອາກອນ5%'); 

            //         }

            //         $gethq->balance = $gethq -> balance + $this->s_paid + $this->r_paid - (2*($receive->amount * 0.15)) + (2*(($receive->amount * 0.15) * 0.05)) ;
            //         $gethq->income  = $gethq -> income + $this->s_paid + $this->r_paid + (2*(($receive->amount * 0.15) * 0.05));
            //         $gethq->expend = $gethq->expend + (2*($receive->amount * 0.15));
            //         $gethq->save();

            //         $getsd->balance=$getsd->balance - $this->s_paid + ( $receive->amount * 0.15 ) - (($receive->amount * 0.15) * 0.05);
            //         $getsd->income=$getsd->income + ( $receive->amount * 0.15 );
            //         $getsd->expend=$getsd->expend + $this->s_paid + (($receive->amount * 0.15) * 0.05) ;
            //         $getsd->save();

            //         $getbr->balance=$getbr->balance - $this->r_paid + ( $receive->amount * 0.15 ) - (($receive->amount * 0.15) * 0.05);
            //         $getbr->income=$getbr->income + ( $receive->amount * 0.15 );
            //         $getbr->expend=$getbr->expend + $this->r_paid + (($receive->amount * 0.15) * 0.05) ;
            //         $getbr->save();

            //         $this->dispatchBrowserEvent('hide-modal-detail');
            //         $this->emit('alert', ['type' => 'success', 'message' => 'ເບິກເຄື່ອງໃຫ້ລູກຄ້າສຳເລັດ!']);
   
            //     }
            //     else
            //     {
            //         $this->emit('alert', ['type' => 'warning', 'message' => 'ກະລຸນາກວດຍອດເງິນໃນບັນຊີ ສາຂາຕົ້ນທາງ ແລະ ປາຍທາງຄືນ!']);
            //     }

            // }
            $this->dispatchBrowserEvent('hide-modal-detail');
            $this->emit('alert', ['type' => 'success', 'message' => 'ເບິກເຄື່ອງໃຫ້ລູກຄ້າສຳເລັດ!']);
    }

    // public function rec_qcod($vc,$codt,$hid,$bsid,$brid) 
    // {
    //    $addcod=new CodClear();
    //    $addcod->valuedt=date('Y-m-d');
    //    $addcod->vcode=$vc;
    //    $addcod->currency_code='LAK';
    //    $addcod->cod_total=$codt;
    //    $addcod->hqid=$hid;
    //    $addcod->branch_send=$bsid;
    //    $addcod->branch_recieve=$brid;
    //    $addcod->status= 1;
    //    $addcod->save();
    // }

    // public function rec_tran($txc,$txid,$am1,$am2,$am3,$cd1,$cd2,$cd3,$br,$ur,$rdt,$des)
    // {
    //          // record ew_tran //
    //         $addtran = new EwTran();
    //         $addtran->txcode=$txc;
    //         $addtran->txid=$txid;    
    //         $addtran->valuedt=date('Y-m-d');
    //         $addtran->currency_code='LAK';
    //         $addtran->amount1=$am1;
    //         $addtran->amount2=$am2;
    //         $addtran->amount3=$am3;
    //         $addtran->code1=$cd1;
    //         $addtran->code2=$cd2;
    //         $addtran->code3=$cd3;
    //         $addtran->user_create=auth()->user()->id;
    //         $addtran->branch_id= $br;
    //         $addtran->user_revert=$ur;
    //         $addtran->revertdt=$rdt;
    //         $addtran->status='N';
    //         $addtran->descs=$des;
    //         $addtran->save();
    // }

    // public function rec_stm($tx,$eid,$eacno,$act,$amt,$trc,$vc,$mc,$descs)
    // {
    //     // record ew_stm //
    //     $addstm= new EwStm();
    //     $addstm->txcode=$tx;
    //     $addstm->valuedt=date('Y-m-d');
    //     $addstm->ewid=$eid;
    //     $addstm->acno=$eacno;
    //     $addstm->currency_code='LAK';
    //     $addstm->action=$act;
    //     $addstm->amount=$amt;
    //     $addstm->trcode=$trc;
    //     $addstm->vcode=$vc;
    //     $addstm->mcode=$mc;
    //     $addstm->status='N';
    //     $addstm->descs=$descs;
    //     $addstm->branch_id=Auth()->user()->branchname->id;
    //     $addstm->user_create=auth()->user()->id;
    //     $addstm->save();

    // }
    

}
