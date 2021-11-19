<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Settings\Dividend;
use Livewire\WithPagination;
use DB;

class DividendComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hiddenId,$name,$status,$percent, $search;

    public function render()
    {
        $div = Dividend::orderBy('id','desc')->paginate(5);
        return view('livewire.admin.settings.dividend-component',compact('div'))->layout('layouts.base');
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
        'name.required'=>'ກະລຸນາເພີ່ມຊື່ເປີເຊັນປັນຜົນກ່ອນ!',
        'percent.required'=>'ກະລຸນາເພີ່ມເປີເຊັນປັນຜົນກ່ອນ'
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
                'name.required'=>'ກະລຸນາເພີ່ມຊື່ເປີເຊັນປັນຜົນກ່ອນ!',
                'percent.required'=>'ກະລຸນາເພີ່ມເປີເຊັນປັນຜົນກ່ອນ'
            ]);
           //DB::table('province')->where('id', $updateId)->update();
           $div_update = Dividend::find($updateId);
           $div_update->update([
               'name' => $this->name,
               'percent'=> $this->percent
               ]);
        }
        else //ເພີ່ມໃໝ່
        {
            $this->validate();
            Dividend::create([
               'name' => $this->name,
               'percent'=> $this->percent
            ]);
        }
        $this->resetField();
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
    }

    public function edit($ids)
    {
        $singleData = Dividend::find($ids);
        $this->name = $singleData->name;
        $this->percent = $singleData->percent;
        $this->hiddenId = $singleData->id;
    }

    public function showDestroy($ids)
    {
        //dd($ids)
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = Dividend::find($ids);
        $this->hiddenId = $singleData->id;
        $this->name=$singleData->name;

    }

    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $div = Dividend::find($ids);
        $div->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }

}
