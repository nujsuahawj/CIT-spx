<?php

namespace App\Http\Livewire\Admin\Transaction;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Condition\Customer;
use App\Models\Settings\CustomerType;
use App\Models\Settings\Branch;
use App\Models\Settings\Province;
use App\Models\Settings\District;
use App\Models\Settings\Distance;
use App\Models\Settings\Village;
use App\Models\Settings\GoodsType;
use App\Models\Settings\packet;
use App\Models\Condition\ProductType;
use App\Models\Settings\CalculatePrice;
use App\Models\Transaction\Matterail;
use App\Models\Transaction\Ewallet;
use App\Models\Transaction\EwTran;
use App\Models\Transaction\EwStm;
use App\Models\Transaction\ListMatterail;
use App\Models\Transaction\ReceiveTransaction;
use Illuminate\Http\Request;
use DB;

class CreateReceiveTransactionComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hiddenId,$hId,$code,$thCode,$cusch;
    public $branch_id,$rcid,$rcname,$rcphone,$r2='NML',$insur,$in_rate=0.03,$in_amount,$dist_id; 
    public $cusid,$cuscode,$cusname,$cusphone,$search_cus,$status, $branch_search, $search_by_cat;
    public $product_type_id,$large=0,$height=0,$longs=0,$weigh=0,$r1='LAK',$amount,$piadtype='SD',$hide_cod='disabled';
    public $pro_id = null;
    public $dis_id = null;
    public $vil_id = null;
    public $isDisabled1 = "",$btnStatus1="",$btnStatus2="Disabled",$dislink="pointer-events: none";
    //public $bill_id = null;
    public $goods_type_id = null;
    public $districts = [];
    public $villages = [];
    public $ProductType = [];
    public $pack= "0|0";

    public function mount()
    {
        $branch_code = auth()->user()->branchname->id;
        $max = ReceiveTransaction::where('branch_create_id',auth()->user()->branchname->id)->count('id');
        if(!empty($max)){
            $sum = $max+1;
            $this->code =  $branch_code.date('ymd').$sum;
        }else{
            $this->code =  $branch_code.auth()->user()->id.date('ymd').'1';
        }

        $max_cus = Customer::select('id')->count('id');
        if(!empty($max_cus)){
            $sum_cus = $max_cus+1;
            $this->code_cus =  'SPXCR'.$sum_cus;
            $this->code_cus_send =  'SPXCS'.$sum_cus;
        }else{
            $this->code_cus =  'SPXCR'.'1';
            $this->code_cus_send =  'SPXCS'.'1';
        }
        $this->code_cus =  'C'.date('Ymdms');
    }

    public function render()
    {
        $branchid  = Auth()->user()->branchname->id;
        $provinces = Province::where('del', 1)->get();
        $districtss = District::orderBy('id','desc')->get();
        $villagess = Village::orderBy('id','desc')->get();
        $packet = Packet::select('id','name','price')->where('status',1)->orderBy('id','desc')->get();

        $dist = District::where('del', 1)->get();
        $vill = Village::where('del', 1)->get();
        $goodstype = GoodsType::where('status',1)->get();
        $ew=Ewallet::select('id','acno','balance')->where('branch_id',Auth()->user()->branchname->id)->where('status','N')->first();
        $matterails = Matterail::select('matterails.id as id','matterails.code','matterails.large','matterails.height','matterails.longs','matterails.weigh','matterails.currency_code',
                                        'matterails.amount','matterails.cod_amount','matterails.insur_amount','matterails.pack_amount','matterails.paid_type','goods_types.name as gname','product_types.name as pname','calculate_prices.name as calname')
                    ->join('goods_types','matterails.goods_id','=','goods_types.id')
                    ->join('product_types','matterails.product_type_id','=','product_types.id')
                    ->join('calculate_prices','matterails.cal_price_id','=','calculate_prices.id')
                    ->where('receive_id',  $this->code) ->paginate(10);

        $distances = Distance::where('status',1)->get();

        $branch = Branch::select('branches.id as id','branches.code','branches.company_name_la as company_name_la','branches.company_name_en as company_name_en','pv.name as pvname','dt.name as dtname','vl.name as vlname')
                          ->join('provinces as pv','branches.pro_id','=','pv.id')
                          ->join('districts as dt','branches.dis_id','=','dt.id')
                          ->join('villages as vl','branches.vill_id','=','vl.id')
                           ->where('branches.id','!=',$branchid)->get();


        if(!empty($this->pro_id)){
            $this->districts = District::where('pro_id', $this->pro_id)->get();
        }

        if(!empty($this->dis_id)){
            $this->villages = Village::where('dis_id', $this->dis_id)->get();
        }

        if(!empty($this->goods_type_id)){
            $this->ProductType = ProductType::where('goods_id', $this->goods_type_id)
            ->where('status',1)->get();
        }

        if($this->r2=='COD' || $this->insur=='TRUE'){ $this->hide_cod=''; } else{ $this->hide_cod='disabled'; $this->amount=0;}
        $customertypes = CustomerType::all();
        $customers = Customer::select('customers.*','provinces.name as proname','districts.name as disname','villages.name as vilname')
        ->leftJoin('provinces', 'customers.pro_id', '=', 'provinces.id')
        ->leftJoin('districts', 'customers.dis_id', '=', 'districts.id')
        ->leftJoin('villages', 'customers.vil_id', '=', 'villages.id')
        ->where('customers.del',1)
        ->where(function($query){
         $query->where('customers.code', 'like', '%' .$this->search_cus. '%')
        ->orWhere('customers.name', 'like', '%' .$this->search_cus. '%')
        ->orWhere('customers.phone', 'like', '%' .$this->search_cus. '%');
         })->where('customers.cus_type_id', 'like', '%' .$this->search_by_cat. '%')->paginate(8);


        return view('livewire.admin.transaction.create-receive-transaction-component',compact('customertypes','customers','branch','provinces','districtss','villagess','dist','vill','goodstype','distances','matterails','ew','packet'))
        ->layout('layouts.base');
    }

    public function get_cus($ids,$ch)
    {
        $singleData = Customer::find($ids);

        if($ch==1)
        {
            $this->cusid = $singleData->id;
            $this->cuscode = $singleData->code;
            $this->cusname = $singleData->name;
            $this->cusphone=$singleData->phone;
            $this->cushiddenId = $singleData->id;
        }else{
            $this->rcid = $singleData->id;
            $this->rcname = $singleData->name;
            $this->rcphone=$singleData->phone;
        }

        $this->dispatchBrowserEvent('hide-modal-cus-info');

    }

    public function resetform()
    {
        
        $this->goods_type_id="";
        $this->product_type_id="";
        $this->large=0;
        $this->height=0;
        $this->longs=0;
        $this->weigh=0;
        //$this->r1="LAK";
        $this->amount= 0;
    }


    public function addOrder()
    {
        $this->validate([
            'dist_id'=>'required','goods_type_id'=>'required','product_type_id'=>'required','large'=>'numeric|min:0','height'=>'numeric|min:0',
            'longs'=>'numeric|min:0','weigh'=>'numeric|min:0','r1'=>'required'
        ],[
            'dist_id.required'=>'ເລືອກເງື່ອນໄຂການຂົນສົ່ງ','goods_type_id.required'=>'ເລືອກປະເພດເຄື່ອງ','product_type_id.required'=>'ເລືອກໝວດໝູ່',
            'large.numeric'=>'ຕື່ມຄ່າ>=0','large.min'=>'ຕື່ມຄ່າ>=0',
            'height.numeric'=>'ຕື່ມຄ່າ>=0','height.min'=>'ຕື່ມຄ່າ>=0',
            'longs.numeric'=>'ຕື່ມຄ່າ>=0','longs.min'=>'ຕື່ມຄ່າ>=0',
            'weigh.numeric'=>'ຕື່ມຄ່າ>=0','weigh.min'=>'ຕື່ມຄ່າ>=0',
            'r1.required'=>'ເລືອກສະກຸນເງິນ'
        ]);

         

        ///////////// start caculate price ////////////////////

         

        $v_price=0;
        $w_price=0;
        $cal_price=0;


        $fprod=ProductType::where('id',$this->product_type_id)->first();

        if($fprod->func_type=='CP')
        {
                $this->v=$this->large + $this->height + $this->longs;
        
                if($this->v<=280 && $this->weigh<=30)
                {
                 

                   $find_price = CalculatePrice::
                                selectRaw('max(id) as id,max(price) AS price') 
                                ->where(function ($query){ $query->where('min_val','<=',$this->weigh)->orWhere('max_val','<=',$this->v); })
                                ->where('cal_type_id',1)
                                ->where('distance_id',$this->dist_id)
                                ->where('status',1)->where('del',1)
                                ->first();
                  
                        if($find_price->id !=null)
                        {
                            $this->cal_price = $find_price->price;
                            $this->fun_id= $find_price->id;
                            $this->rec_matterail();
 
                        } else { $this->emit('alert', ['type' => 'warning', 'message' => 'ເຄື່ອງບໍ່ຢູ່ໃນເງື່ອນໄຂການຄິດໄລ່ເງິນ!']); }

                }
                elseif($this->v<=280 && $this->weigh>30)
                {
                    $find_price=CalculatePrice::select('id','price')->where('min_val','<',$this->weigh)->where('max_val','>=',$this->weigh)
                                                ->where('status',1)->where('cal_type_id',2)->where('distance_id',$this->dist_id)->where('del',1)->first();
                    if($find_price->id !=null)
                    {
                        $this->cal_price = $find_price->price * $this->weigh;
                        $this->fun_id= $find_price->id;
                        $this->rec_matterail();

                    } else { $this->emit('alert', ['type' => 'warning', 'message' => 'ເຄື່ອງບໍ່ຢູ່ໃນເງື່ອນໄຂການຄິດໄລ່ເງິນ!']); }

                }
                else{
                     
                     $this->w_price =($this->large * $this->height * $this->longs)/5000;
                     $find_price=CalculatePrice::select('id','price')->where('min_val','<',$this->w_price)->where('max_val','>=',$this->w_price)
                                                        ->where('status',1)->where('cal_type_id',3)->where('distance_id',$this->dist_id)->where('del',1)->first();
                     if($find_price->id !=null)
                     {
                         $this->cal_price = $find_price->price * $this->w_price;
                         $this->fun_id= $find_price->id;
                         $this->rec_matterail();
 
                     } else { $this->emit('alert', ['type' => 'warning', 'message' => 'ເຄື່ອງບໍ່ຢູ່ໃນເງື່ອນໄຂການຄິດໄລ່ເງິນ!']); }

                }

        }
        elseif($fprod->func_type=='FX')
        {

              
                $find_cal2 = CalculatePrice::select('calculate_prices.id as id','pf.price as price')
                            ->join('price_funcs as pf', 'calculate_prices.id', '=', 'pf.cal_price_id')   
                              //  ->where('calculate_prices.distance_id',$this->dist_id)
                                ->where('pf.currency_code',$this->r1)
                                ->where('calculate_prices.id',$fprod->cal_price_id)->where('del',1)->first();
                             
                if(!empty($find_cal2->id)) {
                                $this->cal_price = $find_cal2->price;
                                $this->fun_id=$find_cal2->id;
                                $this->rec_matterail();
                } else{
                    
                    $this->emit('alert', ['type' => 'warning', 'message' => 'ເຄື່ອງບໍ່ຢູ່ໃນເງື່ອນໄຂການຄິດໄລ່ເງິນການຄິດໄລ່ເງິນ!']);
                }

                                
        }
        else
        {
                  $find_cal2 = CalculatePrice::select('calculate_prices.id as id','pf.price as price')
                            ->join('price_funcs as pf', 'calculate_prices.id', '=', 'pf.cal_price_id')
                        //        ->where('calculate_prices.distance_id',$this->dist_id)
                                ->where('pf.currency_code',$this->r1)
                                ->where('calculate_prices.id',$fprod->cal_price_id)->where('del',1)->first();
                  if(!empty($find_cal2->id) )  {

                                if($find_cal2->cal_type_id==1){
                                     $this->cal_price= $this->v * $find_cal2->price;           
                                }
                                else{
                                    $this->cal_price= $this->weigh * $find_cal2->price;
                                }

                                 $this->fun_id=$find_cal2->id;
                                 $this->rec_matterail();

                  } else{
                    
                    $this->emit('alert', ['type' => 'warning', 'message' => 'ເຄື່ອງບໍ່ຢູ່ໃນເງື່ອນໄຂການຄິດໄລ່ເງິນການຄິດໄລ່ເງິນ!']);
                }                           
                       
        }
  
    }

    public function rec_matterail()
    {
        

        if ((($this->r2=='COD') || ($this->insur=='TRUE')) && ($this->amount==0))
        {
           $this->emit('alert', ['type' => 'warning', 'message' => 'ເພີ່ມລາຄາສິດຄ້າຄົນສົ່ງປະເພດ ໃຫ້ຖືກຕ້ອງ!']);
           
        }
      else
        {
            $th = 'TH'.date('Ymdms');
            $matterail = new Matterail();
            $matterail->code = $th;
            $matterail->receive_id = $this->code;
            $matterail->goods_id = $this->goods_type_id;
            $matterail->product_type_id = $this->product_type_id;
            $matterail->large = $this->large;
            $matterail->height = $this->height;
            $matterail->longs = $this->longs;
            $matterail->weigh = $this->weigh;
            $matterail->cal_price_id = $this->fun_id;
            $matterail->currency_code = $this->r1;
            $matterail->amount = $this->cal_price;
            $matterail->cod_amount = $this->amount;
            if($this->insur=='TRUE')
            {
                $matterail->insur_amount= $this->amount * $this->in_rate;
            }
            else
            {
                $matterail->insur_amount=0;
            }   
            $matterail->pack_id = explode("|",$this->pack)[0];
            $matterail->pack_amount = explode("|",$this->pack)[1];    
            $matterail->paid_type = $this->piadtype;
            $matterail->paid_by = $this->piadtype;
            $matterail->branch_id = Auth()->user()->branchname->id;
            $matterail->usr_create = Auth()->user()->rolename->id;
            $matterail->status ="P";
            $matterail->save();

            $lis_m = new ListMatterail();
            $lis_m->rvcode = $this->code;
            $lis_m->mcode = $th;
            $lis_m->cal_price_id = $this->fun_id;
            $lis_m->currency_code = $this->r1;
            $lis_m->amount = $this->cal_price;
            $lis_m->cod_amount = $this->amount;
            if($this->insur=='TRUE')
            {
                $lis_m->insur_amount= $this->amount * $this->in_rate;
            }
            else
            {
                $lis_m->insur_amount=0;
            }    
            $lis_m->pack_id = explode("|",$this->pack)[0];
            $lis_m->pack_amount = explode("|",$this->pack)[1];      
            $lis_m->paid_type = $this->piadtype;
            $lis_m->paid_by = $this->piadtype;
            $lis_m->branch_id = Auth()->user()->branchname->id;
            $lis_m->usr_create = Auth()->user()->rolename->id;
            $lis_m->status ="P";
            $lis_m->save();
            $this-> resetform(); 
            $this->isDisabled1 = "Disabled";

            $this->pack="0|0";

        }    
        
    }


    public function showCusInfo($ch)
    {
        $this->cusch=$ch;      
        $this->dispatchBrowserEvent('show-modal-cus-info');
    }

    public function showDestroy($id)
    {     
        $singleData = Matterail::find($id);
        $this->hId = $singleData->id;
        $this->thCode=$singleData->code;   
        $this->dispatchBrowserEvent('show-modal-delete');

    }

    public function destroy($ids)
    {
        $delmt = Matterail::find($ids);
        ListMatterail::where('rvcode',$this->code)->where('mcode',$delmt->code )->delete();
        $delmt->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }

    ////////// Bill \\\\\\\\\\\\ branch_id

    public function savebill()
    {
        $this->validate([
            'code'=>'required|unique:matterails','cuscode'=>'required','cusname'=>'required','cusphone'=>'required','rcname'=>'required','rcphone'=>'required',
            'pro_id'=>'required','dis_id'=>'required','vil_id'=>'required','branch_id'=>'required'
        ],[
            'code.required'=>'ລະຫັດບິນບໍ່ສາມາດເປັນຄ່າຫວ່າງ','code.unique'=>'ລະຫັດບິນຊໍ້າກັນ','cuscode.required'=>'ລະຫັດລູກຄ້າບໍ່ສາມາດເປັນຄ່າຫວ່າງ','cusname.required'=>'ຊື່ລູກຄ້າບໍ່ສາມາດເປັນຄ່າຫວ່າງ',
            'cusphone.required'=>'ເບີໂທລູກຄ້າບໍ່ສາມາດເປັນຄ່າຫວ່າງ','rcname.required'=>'ກະລຸນາເລືອກຜູ້ຮັບເຄື່ອງ','rcphone.required'=>'ເບີໂທຜູ້ຮັບເຄື່ອງບໍ່ສາມາດເປັນຄ່າຫວ່າງ',
            'pro_id.required'=>'ເລືອກແຂວງທີ່ຢູ່ຜູ້ຮັບເຄື່ອງ','dis_id.required'=>'ເລືອກເມືອງທີ່ຢູ່ຜູ້ຮັບເຄື່ອງ','vil_id.required'=>'ເລືອກບ້ານທີ່ຢູ່ຜູ້ຮັບເຄື່ອງ','branch_id.required'=>'ເລອກສາຂາປາຍທາງ'
        ]);



        $chekm= DB::table('matterails')
                    ->select(DB::raw('count(receive_id) as c, sum(amount) as m, sum(cod_amount) as cm, sum(insur_amount) as ins,sum(pack_amount) as pkamt'))
                    ->where('receive_id','=',$this->code)
                    ->groupBy('receive_id')
                    ->first();

  
          If(empty($chekm->c))
        {
            $this->emit('alert', ['type' => 'warning', 'message' => 'ກະລຸນາເພີ່ມລາຍການຂົນສົ່ງກ່ອນ!']);
        

        }
        else
        {

           
            $savebill = new ReceiveTransaction();
            $savebill->code = $this->code ;
            $savebill->type='SND_BILL';
            $savebill->valuedt=  date('Y-m-d', time());
            $savebill->branch_send =Auth()->user()->branchname->id ;
            $savebill->customer_send = $this->cusid ;
            $savebill->branch_receive =$this->branch_id ;
            $savebill->customer_receive = $this-> rcid;
            $savebill->pro_id = $this-> pro_id;
            $savebill->dis_id = $this-> dis_id;
            $savebill->vil_id= $this-> vil_id;
            $savebill->currency_code = $this->r1;
            $savebill->amount = $chekm->m;
            $savebill->service_type = $this->r2;
            $savebill->cod_amount = $chekm->cm;
            $savebill->insur=$this->insur;
            $savebill->insur_rate=$this->in_rate;
            $savebill->insur_amount=$chekm->ins;
            $savebill->pack_amount=$chekm->pkamt;
            $savebill->paid_by= $this->piadtype;
            $savebill->creator_id=  Auth()->user()->id;
            $savebill->branch_create_id = Auth()->user()->branchname->id ;
            $savebill-> status= 'N';
            $savebill->save();
            Matterail::where('receive_id', '=', $this->code)->update(['status' => 'N']);
            $this->btnStatus1="Disabled";
            $this->btnStatus2="";
            $this->dislink="";
            $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກສຳເລັດ!']);
            
        }


    }

    public function cancel()
    {
        $delmt = Matterail::where('receive_id',$this->code);
        $delmt->delete();
        ListMatterail::where('rvcode',$this->code)->delete();
        $this->cusid="";
        $this->cuscode="";
        $this->cusname="";
        $this->cusphone="";
        $this->rcid="";
        $this->rcname="";
        $this->rcphone="";
        $this->r2='NML';
        $this->insur=null;
        $this->dist_id=""; 
        $this->pro_id="";
        $this->dis_id="";
        $this->vil_id="";
        $this->btnStatus1="";
        $this->btnStatus2="Disabled";
        $this->isDisabled1 = "";  
        $this->dislink="pointer-events: none";
        $this->mount();
        $this-> resetform(); 
        $this->emit('alert', ['type' => 'success', 'message' => 'ຍົກເລີກລາຍການຂົນສົ່ງນີ້ແລ້ວ']);
  
    }

    public function clear()
    {
        $this->code="";
        $this->cusid="";
        $this->cuscode="";
        $this->cusname="";
        $this->cusphone="";
        $this->rcid="";
        $this->rcname="";
        $this->rcphone="";
        $this->r2='NML';
        $this->insur=null;
        $this->dist_id=""; 
        $this->pro_id="";
        $this->dis_id="";
        $this->vil_id="";
        $this->btnStatus1="";
        $this->btnStatus2="Disabled";
        $this->isDisabled1 = "";
        $this->dislink="pointer-events: none";
        $this->mount();
        $this-> resetform(); 
        $this->emit('alert', ['type' => 'success', 'message' => 'ລ້າງຂໍ້ມູນສຳເລັດ ສາມາດສ້າງລາຍການໃໝ່ໄດ້ເລີຍ']);

           
     
    }

    public function printV()
    {
        Route::get('voucher.printreceive');
    }

    public  $code_cus_send, $namesend,$phonesend, $bodsend, $cus_type_id_send, $notesend;

    public  $code_cus, $name,$phone, $bod, $cus_type_id, $branch_id_cus, $note;

    public function resetCustomerFormsend()
    {
        $this->namesend = ''; $this->phonesend = ''; $this->bodsend; $this->cus_type_id_send; $this->notesend ='';
    }

    public function resetCustomerForm()
    {
        $this->name = ''; $this->phone = ''; $this->bod; $this->cus_type_id;
        $this->branch_id_cus; $this->note ='';
    }

    public function showCusAddSend()
    {
        $this->resetCustomerFormsend();
        $this->dispatchBrowserEvent('show-modal-add-customer-send');
    }

    public function showCusAddReceive()
    {
        $this->resetCustomerForm();
        $this->dispatchBrowserEvent('show-modal-add-customer');
    }

    public function storeCustomerSend()
    {
        $this->validate([
            'code_cus_send'=>'required',
            'namesend'=>'required',
            'cus_type_id_send'=>'required',
            'phonesend'=>'required',
        ],[
            'code_cus_send.required'=>'ໃສ່ລະຫັດບາໂຄດສິນຄ້າກ່ອນ!',
            'code_cus_send.unique'=>'ລະຫັດນີ້ມີໃນລະບົບແລ້ວ!',
            'namesend.required'=>'ໃສ່ຊື່ລູກຄ້າກ່ອນ!',
            'cus_type_id_send.required'=>'ກະລຸນາເລືອກປະເພດລູກຄ້າ',
            'phonesend.required'=>'ກະລຸນາຕື່ມເລກໝາຍເບີໂທລະສັບ',
        ]);

        $customer = new Customer;
        $customer->code = $this->code_cus_send; //str_replace(',','',$request->debit),
        $customer->name = $this->namesend;
        $customer->phone = $this->phonesend;
        $customer->bod = $this->bodsend;
        $customer->cus_type_id = $this->cus_type_id_send;
        $customer->branch_id = auth()->user()->branchname->id;
        $customer->note = $this->notesend;
        $customer->save();

            $this->cusid = $customer->id;
            $this->cuscode = $this->code_cus_send;
            $this->cusname = $this->namesend;
            $this->cusphone=$this->phonesend;
            $this->cushiddenId = $customer->id;
        
        $this->dispatchBrowserEvent('hide-modal-add-customer-send');
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມຂໍ້ມູນຂໍ້ມູນສຳເລັດ!']);
        $this->resetCustomerForm();
    }

    public function storeCustomerReceive()
    {
        $this->validate([
            'code_cus'=>'required',
            'name'=>'required',
            'cus_type_id'=>'required',
            'phone'=>'required',
        ],[
            'code_cus.required'=>'ໃສ່ລະຫັດບາໂຄດສິນຄ້າກ່ອນ!',
            'code_cus.unique'=>'ລະຫັດນີ້ມີໃນລະບົບແລ້ວ!',
            'name.required'=>'ໃສ່ຊື່ລູກຄ້າກ່ອນ!',
            'cus_type_id.required'=>'ກະລຸນາເລືອກປະເພດລູກຄ້າ',
            'phone.required'=>'ກະລຸນາຕື່ມເລກໝາຍເບີໂທລະສັບ',
        ]);

        $customer = new Customer;
        $customer->code = $this->code_cus; //str_replace(',','',$request->debit),
        $customer->name = $this->name;
        $customer->phone = $this->phone;
        $customer->bod = $this->bod;
        $customer->cus_type_id = $this->cus_type_id;
        $customer->branch_id = auth()->user()->branchname->id;
        $customer->note = $this->note;
        $customer->save();

        $this->rcid = $customer->id;
        $this->rcname = $this->name;
        $this->rcphone = $this->phone;
        
        $this->dispatchBrowserEvent('hide-modal-add-customer');
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມຂໍ້ມູນຂໍ້ມູນສຳເລັດ!']);
        $this->resetCustomerForm();
    }



}


