<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Settings\Cod;

class CodRateComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hidenId, $hiddenId, $name, $percent, $search;

    public function render()
    {
        $cod = Cod::orderBy('id','desc')->paginate(5);
        return view('livewire.admin.settings.cod-rate-component',compact('cod'))->layout('layouts.base');
    }

    public function resetField()
    {
        $this->name = '';
        $this->percent = '';
       // $this->status=null;
        $this->hiddenId ='';
    }

    protected $rules = ['name'=>'required','percent'=>'required'];
    
    protected $messages = [
        'name.required'=>'ກະລຸນາເພີ່ມຊື່ COD ກ່ອນ!',
        'percent.required'=>'ກະລຸນາເພີ່ມເປີເຊັນ COD ກ່ອນ'
    ];

    public function store()
    {
        $updateId = $this->hiddenId;

        if($updateId > 0) //Update ໂຕທີ່ເລືອກ
        {
            $this->validate([
                'name'=>'required',
                'percent'=>'required'
            ],[
                'name.required'=>'ກະລຸນາເພີ່ມຊື່ COD ກ່ອນ!',
                'percent.required'=>'ກະລຸນາເພີ່ມເປີເຊັນ COD ກ່ອນ'
            ]);
           //DB::table('province')->where('id', $updateId)->update();
           $div_update = Cod::find($updateId);
           $div_update->update([
               'name' => $this->name,
               'percent'=> $this->percent
               ]);
        }
        else //ເພີ່ມໃໝ່
        {
            $this->validate();
            Cod::create([
               'name' => $this->name,
               'percent'=> $this->percent
            ]);
        }
        $this->resetField();
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
    }

    public function edit($ids)
    {
        $singleData = Cod::find($ids);
        $this->name = $singleData->name;
        $this->percent = $singleData->percent;
        $this->hiddenId = $singleData->id;
    }

    public function showDestroy($ids)
    {
        //dd($ids)
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = Cod::find($ids);
        $this->hiddenId = $singleData->id;
        $this->name=$singleData->name;

    }

    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $div = Cod::find($ids);
        $div->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }
}
