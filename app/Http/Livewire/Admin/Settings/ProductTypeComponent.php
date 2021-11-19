<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Settings\GoodsType;
use App\Models\Settings\ProductType;
use App\Models\Settings\FunctionType;
use App\Models\Settings\CalculatePrice;
use Illuminate\Support\Facades\Auth;
use DB;


class ProductTypeComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $hiddenId ,$name,$goods_id,$parent_id,$status, $search,$goods_search,$func,$caltype,$disabled;
    public $calfunc=[];
    public function render()
    {
        $branchid  = Auth()->user()->branchname->id;
        $goodstype = GoodsType::where('status',1)->orderBy('id','asc')->get();

        if($this->func=='FX' || $this->func=='PU' )
        {
            $this->calfunc = CalculatePrice::where('status',1)->where('func_type', $this->func)->get();
            $this->disabled='';


        }
        else
        {
            $this->caltype=null;
            $this->disabled='disabled';

        }

       

        if($this->goods_search == 0){
            $producttype = ProductType::orderBy('id','desc')
           // ->where('branch_id',Auth()->user()->branchname->id)
            ->where('name', 'like', '%' . $this->search. '%')
            ->paginate(10);
        }
        else{

            $producttype = ProductType::orderBy('id','desc')
        //    ->where('branch_id',Auth()->user()->branchname->id)
            ->where(function($query){
            $query->where('name', 'like', '%' .$this->search. '%');
            })->where('goods_id', '=', $this->goods_search)->paginate(10);

        }

        return view('livewire.admin.settings.product-type-component',compact('producttype','goodstype'))->layout('layouts.base');

    }

    public function resetField()
    {
        $this->name = '';
        $this->goods_id=null;
        $this->func=null;
        $this->caltype=null;
        $this->parent_id=0;
        $this->status=null;
        $this->hiddenId ='';
    }

     //Validate real time
    //protected $rules = ['name'=>'required','goods_id'=>'required','status'=>'required'];
    
  //  protected $messages = [
  //      'name.required'=>'ໃສ່ຊື່ແຂວງກ່ອນ!',
  //      'goods_id.required'=>'ກະລຸນາເລືອກປະເພດເຄື່ອງ!',
  //      'status.required'=>'ກະລຸນາເລືອກສະຖານະ!'
  //  ];

    public function store()
    {
        $updateId = $this->hiddenId;

        if($updateId > 0) //Update ໂຕທີ່ເລືອກ
        {
            if($this->func=='FX' || $this->func=='PU')
            {
                $this->validate([
                    'name'=>'required','goods_id'=>'required','func'=>'required','caltype'=>'required','status'=>'required'
                ],[
                    'name.required'=>'ໃສ່ຊື່ແຂວງກ່ອນ!',
                    'goods_id.required'=>'ກະລຸນາເລືອກປະເພດເຄື່ອງ!',
                    'func.required'=>'ເລກປະເພດການຄຳນວນ!',
                    'caltype.required'=>'ເລືອກລາຍການ!',
                    'status.required'=>'ກະລຸນາເລືອກສະຖານະ!'
                ]);

            }
            else{

                $this->validate([
                    'name'=>'required','goods_id'=>'required','func'=>'required','status'=>'required'
                ],[
                    'name.required'=>'ໃສ່ຊື່ແຂວງກ່ອນ!',
                    'goods_id.required'=>'ກະລຸນາເລືອກປະເພດເຄື່ອງ!',
                    'func.required'=>'ເລກປະເພດການຄຳນວນ!',
                    'status.required'=>'ກະລຸນາເລືອກສະຖານະ!'
                ]);

            }
           //DB::table('province')->where('id', $updateId)->update();
           $pro_update = ProductType::find($updateId);
           $pro_update->update([
               'name' => $this->name,
               'goods_id'=>$this->goods_id,
               'func_type'=>$this->func,
               'cal_price_id'=>$this->caltype,
               'parent_id'=> 1,
               'status'=>$this->status
               ]);
        }
        else //ເພີ່ມໃໝ່
        {
            if($this->func=='FX' || $this->func=='PU')
            {
                $this->validate([
                    'name'=>'required','goods_id'=>'required','func'=>'required','caltype'=>'required','status'=>'required'
                ],[
                    'name.required'=>'ໃສ່ຊື່ແຂວງກ່ອນ!',
                    'goods_id.required'=>'ກະລຸນາເລືອກປະເພດເຄື່ອງ!',
                    'func.required'=>'ເລກປະເພດການຄຳນວນ!',
                    'caltype.required'=>'ເລືອກລາຍການ!',
                    'status.required'=>'ກະລຸນາເລືອກສະຖານະ!'
                ]);

            

            }
            else{

                $this->validate([
                    'name'=>'required','goods_id'=>'required','func'=>'required','status'=>'required'
                ],[
                    'name.required'=>'ໃສ່ຊື່ແຂວງກ່ອນ!',
                    'goods_id.required'=>'ກະລຸນາເລືອກປະເພດເຄື່ອງ!',
                    'func.required'=>'ເລກປະເພດການຄຳນວນ!',
                    'status.required'=>'ກະລຸນາເລືອກສະຖານະ!'
                ]);

              

            }


            ProductType::create([
                'name' => $this->name,
                'goods_id'=>$this->goods_id,
                'func_type'=>$this->func,
                'cal_price_id'=>$this->caltype,
                'branch_id'=>Auth()->user()->branchname->id,
                'parent_id'=> 1,
                'status'=>$this->status
            ]);
        }
        $this->resetField();
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);

              
    }




    public function edit($ids)
    {
        $singleData = ProductType::find($ids);
        $this->name = $singleData->name;
        $this->goods_id = $singleData->goods_id;
        $this->func = $singleData->func_type;
        $this->caltype=$singleData->cal_price_id;
        $this->parent_id = $singleData->parent_id;
        $this->status = $singleData->status;
        $this->hiddenId = $singleData->id;
    }

    public function showDestroy($ids)
    {
        //dd($ids)
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = ProductType::find($ids);
        $this->hiddenId = $singleData->id;
        $this->name=$singleData->name;

    }

    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $branchtype = ProductType::find($ids);
        $branchtype->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }

}




