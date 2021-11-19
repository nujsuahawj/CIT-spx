<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\CalculatePrice;
use App\Models\Settings\Distance;
use App\Models\Settings\CalculateType;
use App\Models\Settings\Branch;
use App\Models\Settings\location;
use App\Models\Settings\FunctionType;
use App\Models\Settings\PriceFunc;

class CalculatePriceComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';

    public $hiddenId, $name,$radio1,$headname, $search,$status;
    public $dist_id,$locate,$cal_type,$min_val, $max_val,$cur1,$caltype,$price, $pricelak=0,$pricethb=0,$priceusd=0,$func,$calname,$disabled1,$disabled2,$disabled3;

    public function render()
    {
        $branchid  = Auth()->user()->branchname->id;
        $distance = Distance::where('status',1)->get();
        $location = location::where('status',1)->get();
        $function = FunctionType::where('status',1)->get();
        $calculateType = CalculateType::where('status',1)->get();

        if($this->func=='FX')
        {
            $this->disabled1="disabled";
            $this->disabled2="disabled";
            $this->disabled3="disabled";       
        }
        elseif($this->func=='PU')
        {
            $this->disabled1="";
            $this->disabled2="disabled";
            $this->disabled3="disabled";  
            $this->max_val=0; 
            $this->min_val=0;   

        }
        else
        {
            $this->disabled1="";
            $this->disabled2="";
            $this->disabled3="";  

        }


        $calculateprice = CalculatePrice::select('calculate_prices.*','distances.name as distname','calculate_types.name as caltypename','function_types.name as funcname')
        ->leftJoin('distances', 'calculate_prices.distance_id', '=', 'distances.id')
        ->leftJoin('function_types','calculate_prices.func_type','=','function_types.id')
        ->leftJoin('calculate_types', 'calculate_prices.cal_type_id', '=', 'calculate_types.id')
        ->where('calculate_prices.del',1)
        ->where(function($query){
         $query->where('calculate_prices.name', 'like', '%' .$this->search. '%')
        ->orWhere('calculate_types.name', 'like', '%' .$this->search. '%');
         })->orderBy('calculate_prices.id','DESC')->paginate(12);

        return view('livewire.admin.settings.calculate-price-component',compact('distance','calculateType','calculateprice','location','function'))->layout('layouts.base');
    }

    //Reset field CustomerType
    public function resetField()
    {
        $this->parent_id = '';
        $this->name = '';
        $this->locate='';
    }

    //Validate realtime CustomerType
    protected $rules = [
        'name'=>'required',
        'locate'=>'required',
        'status'=>'required'
    ];
    protected $messages = [
        'name.required'=>'ໃສ່ຊື່ປາຍທາງຂົນສົ່ງ!',
        'locate.required'=>'ເລືອກຂົງເຂດການຂົນສົ່ງ!',
        'status.required'=>'ກະລຸນາເລືອກສະຖານະການນຳໃຊ້'
    ];


    //Show and store distance
    public function create($a)
    {
        $this->resetField();
        $this->dispatchBrowserEvent('show-modal-add');
        //$this->validate();

        if ($a==1)
        {
            $this->headname=1;
            
        }
        else
        {
            $this->headname=2;
        }
    }


    public function store($a)
    {
        $this->validate();

        if($a==1)
        {
            $distances = new Distance();
            $distances->name = $this->name;
            $distances->locate = $this->locate;
            $distances->branch_id = Auth()->user()->branchname->id;
            $distances->status = $this->status;
            $distances->save();

        }
        else
        {
            $calculateTypes = new CalculateType();
            $calculateTypes->name = $this->name;
            $calculateTypes->branch_id = Auth()->user()->branchname->id;
            $calculateTypes->status = $this->status;
            $calculateTypes->save();
        }

        $this->dispatchBrowserEvent('hide-modal-add');
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
        $this->resetField();
    }

     //Show and Update 
     public function edit($ids,$a)
     {

         $this->dispatchBrowserEvent('show-modal-edit');
         if($a==1)
         {
            $this->headname=1;
            $singleData = Distance::find($ids);
            $this->name = $singleData->name;
            $this->locate = $singleData->locate;
            $this->status=$singleData->status;
            $this->hiddenId = $singleData->id;
 
         }
         else
         {
            $this->headname=2;
            $singleData = CalculateType::find($ids);
            $this->name = $singleData->name;
            $this->status=$singleData->status;
            $this->hiddenId = $singleData->id;

         }

     }

     public function update($a)
     {
         //$this->validate();
         $ids = $this->hiddenId;
         if($a==1)
         {
            $updatedata = Distance::find($ids);
            $updatedata->name = $this->name;
            $updatedata->locate = $this->locate;
            $updatedata->status = $this->status;
            $updatedata->save();

         }
         else
         {
            $updatedata = CalculateType::find($ids);
            $updatedata->name = $this->name;
            $updatedata->status = $this->status;
            $updatedata->save();

         }


         $this->dispatchBrowserEvent('hide-modal-edit');
         $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
         $this->resetField();
     }

      //Show and Delete CustomerType
    public function showDestroyCustomerType($ids,$a)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        if($a==1)
        {
            $singleData = Distance::find($ids);
        }
        else
        {
            $singleData = CalculateType::find($ids);

        }
        
        $this->hiddenId = $singleData->id;
        $this->name = $singleData->name;
        $this->headname=$a;

    }

    public function destroy($ids,$a)
    {
        $ids = $this->hiddenId;
        if($a==1)
        {
            $dropdata = Distance::find($ids);
        }
        else
        {
            $dropdata = CalculateType::find($ids);

        }
       
        $dropdata->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
        $this->resetField();
    }

    public function showAddCalculatePrice()
    {
        $this->resetCalculatePriceForm();
        $this->dispatchBrowserEvent('show-modal-add-customer');
    }

    public function resetCalculatePriceForm()
    {
       $this->calname=''; $this->dist_id = null;$this->func=null; $this->caltype =null; $this->min_val=0; $this->max_val=0; $this->pricelak=0;
       $this->pricethb=0;$this->priceusd=0;$this->status=1;
       
  
    }

    
    public function storeCalculatePrice()
    {

        if ($this->func =='PU')
        {
            $this->validate([
                'calname'=>'required',
                'func'=>'required',
             //   'dist_id'=>'required',
                'caltype'=>'required',
                'status'=>'required'
            ],[
                'calname.required'=>'ກະລຸນາປ້ອນຊື່ສູດຄິດໄລ່ລາຄາ',
                'func.required'=>'ກະລຸນາເລືອກປະເພດສູດ',
               // 'dist_id.required'=>'ກະລຸນາເລືອກປາຍທາງ',
                'caltype.required'=>'ກະລຸນາເລືອກເງື່ອນໄຂກ່ອນ',
                'status.required'=>'ກະລຸນາເລືອກສະຖານະ'
            ]);

            $this->rec_cal_price();

        }
        elseif($this->func =='FX')
        {
             
            $this->validate([
                'calname'=>'required',
                'func'=>'required',
            //    'dist_id'=>'required',
                'status'=>'required'
            ],[
                'calname.required'=>'ກະລຸນາປ້ອນຊື່ສູດຄິດໄລ່ລາຄາ',
                'func.required'=>'ກະລຸນາເລືອກປະເພດສູດ',
            //    'dist_id.required'=>'ກະລຸນາເລືອກປາຍທາງ',
                'status.required'=>'ກະລຸນາເລືອກສະຖານະ'
            ]);

            $this->rec_cal_price();

        }
        else
        {
            $this->validate([
                'calname'=>'required',
                'func'=>'required',
                'dist_id'=>'required',
                'caltype'=>'required',
                'min_val'=>'required',
                'max_val'=>'required',
                'status'=>'required'
            ],[
                'calname.required'=>'ກະລຸນາປ້ອນຊື່ສູດຄິດໄລ່ລາຄາ',
                'func.required'=>'ກະລຸນາເລືອກປະເພດສູດ',
                'dist_id.required'=>'ກະລຸນາເລືອກປາຍທາງ',
                'caltype.required'=>'ກະລຸນາເລືອກເງື່ອນໄຂກ່ອນ',
                'min_val.required'=>'ກະລຸນາໃສ່ຂອບເຂດນ້ອຍສຸດ',
                'max_val.required'=>'ກະລຸນາໃສ່ຂອບເຂດໃຫຍ່ສຸດ',
                'status.required'=>'ກະລຸນາເລືອກສະຖານະ'
            ]);

            $this->rec_cal_price();

        }
        
        
        
    }


    public function rec_cal_price()
    {
        $calprice = new CalculatePrice();
        $calprice->name = $this->calname;
        $calprice->distance_id = $this->dist_id; //str_replace(',','',$request->debit),
        $calprice->func_type = $this->func;
        $calprice->cal_type_id = $this->caltype;
        $calprice->min_val = $this->min_val;
        $calprice->max_val = $this->max_val;
        $calprice->price = $this->pricelak;
        $calprice->currency_code= 'LAK';
        $calprice->branch_id =Auth()->user()->branchname->id;
        $calprice->status = $this->status;
        $calprice->del = 1;
        $calprice->save();
        

        $delprice = PriceFunc::where('cal_price_id',$calprice->id);
        $delprice->delete();

        $price_func = new PriceFunc();
        $price_func->cal_price_id=$calprice->id;
        $price_func->currency_code='LAK';
        $price_func->price=$this->pricelak;
        $price_func->save();
        $price_func = new PriceFunc();
        $price_func->cal_price_id=$calprice->id;
        $price_func->currency_code='THB';
        $price_func->price=$this->pricethb;
        $price_func->save();
        $price_func = new PriceFunc();
        $price_func->cal_price_id=$calprice->id;
        $price_func->currency_code='USD';
        $price_func->price=$this->priceusd;
        $price_func->save();


        
        
        $this->dispatchBrowserEvent('hide-modal-add-customer');
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມຂໍ້ມູນຂໍ້ມູນສຳເລັດ!']);
        //return redirect(route('admin.catalog'));
        $this->resetCalculatePriceForm();

    }

    //Show and Update cal_price
    public function showEditCalculate($ids)
    {
        $this->resetCalculatePriceForm();
        $this->dispatchBrowserEvent('show-modal-edit-customer');
        $singleData = CalculatePrice::find($ids);
        $this->hiddenId = $singleData->id;
        $this->calname = $singleData->name;
        $this->dist_id = $singleData->distance_id;
        $this->func = $singleData->func_type;
        $this->caltype = $singleData->cal_type_id;
        $this->min_val = $singleData->min_val;
        $this->max_val = $singleData->max_val;
        $this->status = $singleData->status;

        $showprice = PriceFunc::where('cal_price_id',$ids)->get();
        foreach($showprice as $item)
        {
             if($item->currency_code=='LAK'){ $this->pricelak= $item->price;}
             if($item->currency_code=='THB'){ $this->pricethb= $item->price;}
             if($item->currency_code=='USD'){ $this->priceusd= $item->price;}

        }
     
       
    }

    public function updateCalculate()
    {
        $ids = $this->hiddenId;
        $updatecal = CalculatePrice::find($ids);
        $updatecal->name = $this->calname; 
        $updatecal->distance_id = $this->dist_id; //str_replace(',','',$request->debit),
        $updatecal->func_type = $this->func;
        $updatecal->cal_type_id = $this->caltype;
        $updatecal->min_val = $this->min_val;
        $updatecal->max_val = $this->max_val;
        $updatecal->price = $this->pricelak;
        $updatecal->currency_code='LAK';
       // $updatecal->branch_id =Auth()->user()->branchname->id;
        $updatecal->status = $this->status;
        $updatecal->save();
        
        $up_price_func = PriceFunc::where('cal_price_id',$ids)->where('currency_code','LAK')->first();
        $up_price_func->price=$this->pricelak;
        $up_price_func->save();
        $up_price_func = PriceFunc::where('cal_price_id',$ids)->where('currency_code','THB')->first();
        $up_price_func->price=$this->pricethb;
        $up_price_func->save();
        $up_price_func = PriceFunc::where('cal_price_id',$ids)->where('currency_code','USD')->first();
        $up_price_func->price=$this->priceusd;
        $up_price_func->save();



        $this->dispatchBrowserEvent('hide-modal-edit-customer');
        $this->emit('alert', ['type' => 'success', 'message' => 'ແກ້ໄຂຂໍ້ມູນສຳເລັດ!']);
        $this->resetCalculatePriceForm();
    }

    //Show and Delete cal_price
    public function showDestroyCalculate($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete-customer');
        $singleData = CalculatePrice::find($ids);
        $this->hiddenId = $singleData->id;
    }
    public function destroyCalculate()
    {
        $ids = $this->hiddenId;
        $delcal = CalculatePrice::find($ids);
        $delcal->del = 0;
        $delcal->save();

        $this->dispatchBrowserEvent('hide-modal-delete-customer');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }




}
