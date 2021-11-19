<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Settings\BranchType;
use DB;
class BranchTypeComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hiddenId, $name,$deposit,$note, $search;

    public function render()
    {
        
        $branchtype = BranchType::orderBy('id','desc')
            ->where('name', 'like', '%' . $this->search. '%')
            ->paginate(5);

        return view('livewire.admin.settings.branch-type-component', compact('branchtype'))->layout('layouts.base');
        
    }

    public function resetField()
    {
        $this->name = '';
        $this->deposit=0;
        $this->note='';
        $this->hiddenId ='';
    }

     //Validate real time
    protected $rules = ['name'=>'required|unique:branch_types','deposit'=>'numeric|min:0'];
    
    protected $messages = [
        'name.required'=>'ໃສ່ຊື່ແຂວງກ່ອນ!',
        'name.unique'=>'ຊື່ແຂວງນີ້ໄດ້ມີໃນລະບົບແລ້ວ!',
        'deposit.numeric'=>'ປະເພດຂໍ້ຄວາມຕ້ອງເປັນຕົວເລກ',
        'deposit.min'=>'ມູນຄ່າຕ້ອງໃຫຍ່ກວ່າ 0'
    ];

    public function store()
    {
        $updateId = $this->hiddenId;

        if($updateId > 0) //Update ໂຕທີ່ເລືອກ
        {
            $this->validate([
                'name'=>'required'
            ],[
                'name.required'=>'ເພີ່ມຊື່ກ່ອນ!'
            ]);
           //DB::table('province')->where('id', $updateId)->update();
           $pro_update = BranchType::find($updateId);
           $pro_update->update([
               'name' => $this->name,
               'depoeit'=> $this->deposit,
               'note'=>$this->note
               ]);
        }
        else //ເພີ່ມໃໝ່
        {
            $this->validate();
            BranchType::create([
                'name'=>$this->name,
                'deposit'=>$this->deposit,
                'note'=>$this->note
            ]);
        }
        $this->resetField();
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
    }

    public function edit($ids)
    {
        $singleData = BranchType::find($ids);
        $this->name = $singleData->name;
        $this->deposit = $singleData->deposit;
        $this->note = $singleData->note;
        $this->hiddenId = $singleData->id;
    }

    public function showDestroy($ids)
    {
        //dd($ids)
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = BranchType::find($ids);
        $this->hiddenId = $singleData->id;

    }

    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $branchtype = BranchType::find($ids);
        $branchtype->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }





}
