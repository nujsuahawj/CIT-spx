<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Settings\CustomerType;
use DB;
class CustomerTypeComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $hiddenId,$name,$parent_id,$status, $search;

    public function render()
    {
        $customertype = CustomerType::orderBy('id','desc')
            ->where('name', 'like', '%' . $this->search. '%')
            ->paginate(5);
        return view('livewire.admin.settings.customer-type-component',compact('customertype'))->layout('layouts.base');
    }

    public function resetField()
    {
        $this->name = '';
        $this->parent_id=0;
        $this->status=1;
        $this->hiddenId ='';
    }

     //Validate real time
    protected $rules = ['name'=>'required','status'=>'required'];
    
    protected $messages = [
        'name.required'=>'ໃສ່ຊື່ປະເພດລູກຄ້າກ່ອນ!',
        'status.required'=>'ກະລຸນາເລືອກສະຖານະ ການໃຊ້ງານ'
    ];

    public function store()
    {
        $updateId = $this->hiddenId;

        if($updateId > 0) //Update ໂຕທີ່ເລືອກ
        {
            $this->validate([
                'name'=>'required','status'=>'required'
            ],[
                'name.required'=>'ເພີ່ມຊື່ກ່ອນ!',
                'status.required'=>'ກະລຸນາເລືອກສະຖານະ ການໃຊ້ງານ'     
            ]);
           //DB::table('province')->where('id', $updateId)->update();
           $pro_update = CustomerType::find($updateId);
           $pro_update->update([
               'name' => $this->name,
               'parent_id'=> $this->parent_id,
               'status'=>$this->status
               ]);
        }
        else //ເພີ່ມໃໝ່
        {
            $this->validate();
            CustomerType::create([
               'name' => $this->name,
               'parent_id'=> $this->parent_id,
               'status'=>$this->status
            ]);
        }
        $this->resetField();
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
    }


    public function edit($ids)
    {
        $singleData = CustomerType::find($ids);
        $this->name = $singleData->name;
        $this->parent_id = $singleData->parent_id;
        $this->status=$singleData->status;
        $this->hiddenId = $singleData->id;
    }

    public function showDestroy($ids)
    {
        //dd($ids)
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = CustomerType::find($ids);
        $this->hiddenId = $singleData->id;
        $this->name=$singleData->name;

    }

    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $branchtype = CustomerType::find($ids);
        $branchtype->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }







}
