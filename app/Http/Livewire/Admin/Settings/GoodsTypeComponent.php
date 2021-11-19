<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Settings\GoodsType;
use App\Models\Settings\ProductType;
use App\Models\Transaction\Matterail;
use DB;

class GoodsTypeComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $hiddenId, $name,$parent_id,$status, $search;

    public function render()
    {
        $goodstype = GoodsType::orderBy('id','desc')
            ->where('name', 'like', '%' . $this->search. '%')
            ->paginate(5);
        return view('livewire.admin.settings.goods-type-component',compact('goodstype'))->layout('layouts.base');
    }
    public function resetField()
    {
        $this->name = '';
        $this->parent_id=0;
        $this->hiddenId ='';
        $this->status=1;
    }

     //Validate real time
    protected $rules = ['name'=>'required|unique:goods_types','status'=>'required'];
    
    protected $messages = [
        'name.required'=>'ໃສ່ຊື່ແຂວງກ່ອນ!',
        'name.unique'=>'ຊື່ປະເພດເຄື່ອງ ມີໃນລະບົບແລ້ວ!',
        'status.required'=>'ກະລຸນາເລືອກສະຖານະ ການນຳໃຊ້'
    ];

    public function store()
    {
        $updateId = $this->hiddenId;

        if($updateId > 0) //Update ໂຕທີ່ເລືອກ
        {
            $this->validate([
                'name'=>'required',
                'status'=>'required'
            ],[
                'name.required'=>'ເພີ່ມຊື່ກ່ອນ!',
                'status.required'=>'ກະລຸນາເລືອກສະຖານະ ການນຳໃຊ້'
            ]);
           //DB::table('province')->where('id', $updateId)->update();
           $pro_update = GoodsType::find($updateId);
           $pro_update->update([
               'name' => $this->name,
               'parent_id'=> $this->parent_id,
               'status'=>$this->status
               ]);
        }
        else //ເພີ່ມໃໝ່
        {
            $this->validate();
            GoodsType::create([
                'name'=>$this->name,
                'branch_id'=>Auth()->user()->branchname->id,
                'parent_id'=>$this->parent_id,
                'status'=>$this->status
            ]);
        }
        $this->resetField();
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
    }

    public function edit($ids)
    {
        $singleData = GoodsType::find($ids);
        $this->name = $singleData->name;
        $this->parent_id = $singleData->parent_id;
        $this->status=$singleData->status;
        $this->hiddenId = $singleData->id;
    }

    public function showDestroy($ids)
    {
        //dd($ids)
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = GoodsType::find($ids);
        $this->hiddenId = $singleData->id;
        $this->name=$singleData->name;
    }

    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $productype = ProductType::where('goods_id', $ids)->first();
        $matterial = Matterail::where('goods_id', $ids)->first();
        if(!empty($productype) || !empty($matterial)){
            $this->dispatchBrowserEvent('hide-modal-delete');
            $this->emit('alert', ['type' => 'error', 'message' => 'ບໍ່ສາມາດລົບໄດ້! ທຸລະກຳນີ້ໄດ້ຖືກໃຊ້ງານຢູ່! ']);
        }else{
            $branchtype = GoodsType::find($ids);
            $branchtype->delete();
            $this->dispatchBrowserEvent('hide-modal-delete');
            $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
            $this->resetField();
        }

    }



}
