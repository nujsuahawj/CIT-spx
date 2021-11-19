<?php

namespace App\Http\Livewire\Admin\Address;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Settings\Province;
use App\Models\Settings\District;

class DistrictComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hiddenId, $name, $pro_id, $search;

    public function render()
    {
        $provinces = Province::where('del',1)->get();
        $districts = District::orderBy('id','desc')
            ->where('name', 'like', '%' . $this->search . '%')
            ->where('del',1)->paginate(10);

        return view('livewire.admin.address.district-component',[
            'districts'=> $districts, 'provinces'=> $provinces
        ])->layout('layouts.base');
    }

    public function resetField()
    {
        $this->name = '';
        $this->pro_id = '';
        $this->hiddenId = '';
    }

    protected $rules = [
        'name'=>'required',
        'pro_id'=> 'required'
    ];
    protected $messages = [
        'name.required'=>'ໃສ່ຊື່ເມືອງກ່ອນ!',
        'pro_id.required'=>'ເລືອກແຂວງກ່ອນ!'
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $updateId = $this->hiddenId;
        $validateData = $this->validate();

        if($updateId > 0)
        {
            $dis_update = District::find($updateId);
            $dis_update->update($validateData);
        }
        else
        {
            District::create($validateData);
        }
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
        $this->resetField();
    }

    public function edit($ids)
    {
        $singleData = District::find($ids);
        $this->name = $singleData->name;
        $this->pro_id = $singleData->pro_id;
        $this->hiddenId = $singleData->id;
    }

    public function showDestroy($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = Province::find($ids);
        $this->hiddenId = $singleData->id;
    }
    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $districts = District::find($ids);
        if($districts->proname()->exists())
        {
            $this->dispatchBrowserEvent('hide-modal-delete');
            $this->emit('alert', ['type' => 'warning', 'message' => 'ບໍ່ສາມາດລຶບໄດ້ ເພາະຂໍ້ມູນນີ້ມີຜູກັບຕາຕະລາງອື່ນ!!']);
        }else
        {
            $districts->del = 0;
            $districts->save();
            $this->dispatchBrowserEvent('hide-modal-delete');
            $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
        }
    }
}
