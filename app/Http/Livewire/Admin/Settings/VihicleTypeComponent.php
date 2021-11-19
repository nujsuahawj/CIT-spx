<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Condition\VihicleType;
use DB;

class VihicleTypeComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hiddenId,$name,$status, $search;

    public function render()
    {
        $vihicletype = VihicleType::orderBy('id','desc')
        ->where('name', 'like', '%' . $this->search. '%')
        ->paginate(5);
        return view('livewire.admin.settings.vihicle-type-component',compact('vihicletype'))->layout('layouts.base');
    }

    public function resetField()
    {
        $this->name = '';
       // $this->status=null;
        $this->hiddenId ='';
    }

     //Validate real time
    protected $rules = ['name'=>'required','status'=>'required'];
    
    protected $messages = [
        'name.required'=>'ໃສ່ຊື່ປະເພດລູກຄ້າກ່ອນ!',
        'status.required'=>'ກະລຸນາເລືອກສະຖານະກ່ອນ'
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
                'status.required'=>'ກະລຸນາເລືອກສະຖານະກ່ອນ'
            ]);
           //DB::table('province')->where('id', $updateId)->update();
           $vih_update = VihicleType::find($updateId);
           $vih_update->update([
               'name' => $this->name,
               'status'=> $this->status
               ]);
        }
        else //ເພີ່ມໃໝ່
        {
            $this->validate();
            VihicleType::create([
               'name' => $this->name,
               'status'=> $this->status
            ]);
        }
        $this->resetField();
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
    }


    public function edit($ids)
    {
        $singleData = VihicleType::find($ids);
        $this->name = $singleData->name;
        $this->status = $singleData->status;
        $this->hiddenId = $singleData->id;
    }

    public function showDestroy($ids)
    {
        //dd($ids)
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = VihicleType::find($ids);
        $this->hiddenId = $singleData->id;
        $this->name=$singleData->name;

    }

    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $vihicletype = VihicleType::find($ids);
        $vihicletype->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }
}
