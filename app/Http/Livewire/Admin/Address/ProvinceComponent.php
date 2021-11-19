<?php

namespace App\Http\Livewire\Admin\Address;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Settings\Province;
use DB;

class ProvinceComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hiddenId, $name, $search;

    public function render()
    {
        $provinces = Province::orderBy('id','desc')
            ->where('name', 'like', '%' . $this->search. '%')
            ->where('del',1)->paginate(10);

        return view('livewire.admin.address.province-component',[
            'provinces'=>$provinces
        ])->layout('layouts.base');
    }

    public function resetField()
    {
        $this->name = '';
        $this->hiddenId ='';
    }
    //Validate real time
    protected $rules = [
        'name'=>'required|unique:provinces'
    ];
    protected $messages = [
        'name.required'=>'ໃສ່ຊື່ແຂວງກ່ອນ!',
        'name.unique'=>'ຊື່ແຂວງນີ້ໄດ້ມີໃນລະບົບແລ້ວ!'
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $updateId = $this->hiddenId;

        if($updateId > 0) //Update ໂຕທີ່ເລືອກ
        {
            $this->validate([
                'name'=>'required'
            ],[
                'name.required'=>'ເພີ່ມຊື່ແຂວງກ່ອນ!'
            ]);
           //DB::table('province')->where('id', $updateId)->update();
           $pro_update = Province::find($updateId);
           $pro_update->update([
               'name' => $this->name
               ]);
        }
        else //ເພີ່ມໃໝ່
        {
            $validateData = $this->validate();
            Province::create($validateData);
        }
        $this->resetField();
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
    }

    public function edit($ids)
    {
        $singleData = Province::find($ids);
        $this->name = $singleData->name;
        $this->hiddenId = $singleData->id;
    }

    public function showDestroy($ids)
    {
        //dd($ids);
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = Province::find($ids);
        $this->hiddenId = $singleData->id;
    }

    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $provinces = Province::find($ids);
        if($provinces->districtname()->exists())
        {
            $this->dispatchBrowserEvent('hide-modal-delete');
            $this->emit('alert', ['type' => 'warning', 'message' => 'ບໍ່ສາມາດລຶບໄດ້ ເພາະຂໍ້ມູນນີ້ມີຜູກັບຕາຕະລາງອື່ນ!!']);
        }else
        {
            $provinces->del = 0;
            $provinces->save();
            $this->dispatchBrowserEvent('hide-modal-delete');
            $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
        }
        
    }
}
