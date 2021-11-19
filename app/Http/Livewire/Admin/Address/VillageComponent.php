<?php

namespace App\Http\Livewire\Admin\Address;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Settings\Province;
use App\Models\Settings\District;
use App\Models\Settings\Village;

class VillageComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hiddenId, $name, $search;
    public $pro_id = null;
    public $dis_id = null;
    public $districts = [];

    public function render()
    {
        $villages = Village::orderBy('id','desc')->where('name', 'like', '%' . $this->search . '%')->where('del',1)->paginate(10);

        if(!empty($this->pro_id)){
            $this->districts = District::where('pro_id', $this->pro_id)->get();
        }

        return view('livewire.admin.address.village-component',[
            'villages'=> $villages
            ])->withProvinces(Province::where('del',1)->get())
            ->layout('layouts.base');
    }

    public function updatedpro_id($id)
    {
        $this->districts = District::where('pro_id', $id)->get();
    }

    public function resetField()
    {
        $this->name = '';
        $this->dis_id = '';
        $this->pro_id = '';
        $this->hiddenId = '';
    }

    protected $rules = [
        'name'=>'required',
        'dis_id'=> 'required',
        'pro_id'=> 'required'
    ];
    protected $messages = [
        'name.required'=>'ໃສ່ຊື່ເມືອງກ່ອນ!',
        'dis_id.required'=>'ເລືອກເມືອງກ່ອນ!',
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
            $vill_update = Village::find($updateId);
            $vill_update->update($validateData);
        }
        else
        {
            Village::create($validateData);
        }
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
        $this->resetField();
    }

    public function edit($ids)
    {
        $singleData = Village::find($ids);
        $this->name = $singleData->name;
        $this->dis_id = $singleData->dis_id;
        $this->pro_id = $singleData->pro_id;
        $this->hiddenId = $singleData->id;
    }

    public function showDestroy($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = Village::find($ids);
        $this->hiddenId = $singleData->id;
    }
    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $villages = Village::find($ids);
        if($villages->disname()->exists())
        {
            $this->dispatchBrowserEvent('hide-modal-delete');
            $this->emit('alert', ['type' => 'warning', 'message' => 'ບໍ່ສາມາດລຶບໄດ້ ເພາະຂໍ້ມູນນີ້ມີຜູກັບຕາຕະລາງອື່ນ!']);
        }else
        {
            $villages->del = 0;
            $villages->save();
            $this->dispatchBrowserEvent('hide-modal-delete');
            $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
        }
    }
}
