<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Settings\ShippingStatus;

class ShippingStatusComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hidenId, $hiddenId, $name, $search;

    public function render()
    {
        $shipping_status = ShippingStatus::orderBy('id','desc')->paginate(5);
        return view('livewire.admin.settings.shipping-status-component',compact('shipping_status'))->layout('layouts.base');
    }
    public function resetField()
    {
        $this->name = '';
        $this->percent = '';
        $this->hiddenId ='';
    }

    protected $rules = ['name'=>'required'];
    
    protected $messages = [
        'name.required'=>'ກະລຸນາເພີ່ມຊື່ ສະຖານະສົ່ງ ກ່ອນ!',
    ];

    public function store()
    {
        $updateId = $this->hiddenId;

        if($updateId > 0) //Update ໂຕທີ່ເລືອກ
        {
            $this->validate([
                'name'=>'required',
            ],[
                'name.required'=>'ກະລຸນາເພີ່ມຊື່ ສະຖານະສົ່ງ ກ່ອນ!',
            ]);
           //DB::table('province')->where('id', $updateId)->update();
           $div_update = ShippingStatus::find($updateId);
           $div_update->update([
               'name' => $this->name,
               ]);
        }
        else //ເພີ່ມໃໝ່
        {
            $this->validate();
            ShippingStatus::create([
               'name' => $this->name,
            ]);
        }
        $this->resetField();
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
    }

    public function edit($ids)
    {
        $singleData = ShippingStatus::find($ids);
        $this->name = $singleData->name;
        $this->hiddenId = $singleData->id;
    }

    public function showDestroy($ids)
    {
        //dd($ids)
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = ShippingStatus::find($ids);
        $this->hiddenId = $singleData->id;
        $this->name=$singleData->name;

    }

    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $div = ShippingStatus::find($ids);
        $div->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }
}
