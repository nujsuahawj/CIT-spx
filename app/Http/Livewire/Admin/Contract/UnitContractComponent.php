<?php

namespace App\Http\Livewire\Admin\Contract;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Condition\UnitContract;
use App\Models\Settings\Branch;
use App\Models\Settings\BranchType;

class UnitContractComponent extends Component
{
    use WithFileUploads; use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hidenId, $hiddenId, $code, $branch_search, $search;

    public function mount()
    {
        $contract = UnitContract::orderBy('id','desc')->first();
        $max = 1;
        if(!empty($contract->id)){
            $max = $contract->id + 1;
        }
        $this->code = 'UNT-'.$max;
    }
    
    public function render()
    {
        $branch = Branch::orderBy('id','desc')->get();
        $branch_type = BranchType::orderBy('id','desc')->get();
        if(auth()->user()->rolename->name == 'admin')
        {
            if(!empty($this->branch_search))
            {
                $unit_contract = UnitContract::orderBy('id', 'desc')
                ->where(function($query){
                    $query->where('code', 'like', '%' .$this->search. '%');
                })->where('branch_id', 'like', '%' .$this->branch_search. '%')->paginate(10);
            }else{ //else Branch search
                $unit_contract = UnitContract::orderBy('id', 'desc')
                    ->where(function($query){
                        $query->where('code', 'like', '%' .$this->search. '%');
                    })->paginate(10);
            }
        }else{ // else Admin
            $unit_contract = UnitContract::orderBy('id', 'desc')
            ->where(function($query){
                $query->where('code', 'like', '%' .$this->search. '%');
            })->where('branch_id', auth()->user()->branchname->id)->paginate(10);
        }
        
        return view('livewire.admin.contract.unit-contract-component', compact('branch','branch_type','unit_contract'))->layout('layouts.base');
    }

    public $unit_id, $unit_type_id, $start_date, $end_date, $money, $file, $note, $status;

    public function resetForm()
    {
        $contract = UnitContract::orderBy('id','desc')->first();
        $max = 1;
        if(!empty($contract->id)){
            $max = $contract->id + 1;
        }
        $this->code = 'UNT-'.$max;

        $this->unit_id = "";
        $this->unit_type_id = "";
        $this->money = '';
        $this->note = '';
    }

    public function showAddContract()
    {
        $this->dispatchBrowserEvent('show-modal-add-contract');
    }

    public function saveContract()
    {
        $this->validate([
            'code'=>'required|unique:unit_contracts',
            'unit_id'=>'required',
            'unit_type_id'=>'required',
            'money'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
        ],[
            'code.required'=>'ໃສ່ລະຫັດ ສັນຍາ ກ່ອນ!',
            'unit_id.unique'=>'ກະລຸນາເລືອກໜ່ວຍບໍລິການກ່ອນ!',
            'unit_type_id.required'=>'ກະລຸນາເລືອກປະເພດໜ່ວຍບໍລິການກ່ອນ!',
            'money.required'=>'ກະລຸນາເພີ່ມຈຳນວນເງິນມັດຈຳກ່ອນ!',
            'start_date.required'=>'ກະລຸນາເລືອກວັນທີເລີ່ມສັນຍາກ່ອນ!',
            'end_date.required'=>'ກະລຸນາເລືອກວັນທີໝົດສັນຍາກ່ອນ!',
        ]);
        $money = str_replace(',','',$this->money);
        $contract = new UnitContract;
        $contract->code = $this->code;
        $contract->branch_id = $this->unit_id;
        $contract->branch_type_id = $this->unit_type_id;
        $contract->amount = $money;
        $contract->start_date = $this->start_date;
        $contract->end_date = $this->end_date;
        if(!empty($this->file)){
            $contract->file = $this->file->store('upload/contract');
        }
        $contract->note = $this->note;
        $contract->user_id = auth()->user()->id;
        $contract->save();
        $this->dispatchBrowserEvent('hide-modal-add-contract');
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມຂໍ້ມູນຂໍ້ມູນສຳເລັດ!']);
        $this->resetForm();
    }

    public $unit_id_edit, $unit_type_id_edit;

    public function showEdit($id)
    {
        $this->dispatchBrowserEvent('show-modal-edit-contract');
        $contract = UnitContract::find($id);
        $this->hiddenId = $contract->id;
        $this->code = $contract->code;
        $this->unit_id = $contract->branch_id;
        $this->unit_type_id = $contract->branch_type_id;
        $this->money = $contract->amount;
        $this->start_date = $contract->start_date;
        $this->end_date = $contract->end_date;
        $this->note = $contract->note;
        $this->status = $contract->status;
    }

    public function updateContract()
    {
        // dd($this->unit_id);
        $money = str_replace(',','',$this->money);
        $contract = UnitContract::find($this->hiddenId);
        $contract->code = $this->code;
        $contract->branch_id = $this->unit_id;
        $contract->branch_type_id = $this->unit_type_id;
        $contract->amount = $money;
        $contract->start_date = $this->start_date;
        $contract->end_date = $this->end_date;
        $contract->note = $this->note;
        $contract->status = $this->status;
        if(!empty($this->file)){
            $contract->file = $this->file->store('upload/contract');
        }
        $contract->user_id = auth()->user()->id;
        $contract->save();
        $this->dispatchBrowserEvent('hide-modal-edit-contract');
        $this->emit('alert', ['type' => 'success', 'message' => 'ແກ້ໄຂຂໍ້ມູນຂໍ້ມູນສຳເລັດ!']);
        $this->resetForm();
    }

    public function showDestroyContract($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete-contract');
        $singleData = UnitContract::find($ids);
        $this->hiddenId = $singleData->id;
        $this->code = $singleData->code;
    }
    public function destroyContract()
    {
        $ids = $this->hiddenId;
        $contract = UnitContract::find($ids);
        $contract->delete();
        $this->dispatchBrowserEvent('hide-modal-delete-contract');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }

    public function download($ids)
    {
        $contract = UnitContract::find($ids);
        return response()->download(public_path($contract->file));
    }
}
