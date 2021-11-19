<?php

namespace App\Http\Livewire\Admin\Expenses;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaction\IncomeExpenses;
use App\Models\Settings\Branch;
use App\Models\User;
use DB;

class ExpensesComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $code, $type_id, $des, $amount, $file, $user_id, $branch_id, $created_at, $hiddenId, $type_id_search, $search_by_stype, $search;

    public function mount()
    {
        $this->code = $code = 'EMP'.date('Ymdms');
        
    }

    public function render()
    {
        $expenses = IncomeExpenses::all();
        $allbranch = Branch::all();
        $alluser = User::all();

        if(empty($this->search_by_stype)){

            $expenses=IncomeExpenses::where(function($query){
                $query->where('des', 'like', '%' .$this->search. '%')
                ->orwhere('code','like','%'.$this->search.'%')
                ->orwhere('amount','like','%'.$this->search.'%');
             })->paginate(10);

        }else{

            $expenses=IncomeExpenses::where(function($query){
                $query->where('des', 'like', '%' .$this->search. '%')
                ->orwhere('code','like','%'.$this->search.'%')
                ->orwhere('amount','like','%'.$this->search.'%');
             })->where('type_id', 'like', '%' .$this->search_by_stype. '%')
             ->paginate(10);
        }

        return view('livewire.admin.expenses.expenses-component',compact('expenses','allbranch','alluser'))->layout('layouts.base');
    }

    public function resetField()
    {
        $this->type_id = '';
        $this->des = '';
        $this->amount = '';
        $this->user_id = '';
        $this->branch_id = '';
        $this->created_at = '';
        
    }

    public function create()
    {
        $this->resetField();
        $this->dispatchBrowserEvent('show-modal-add');
    }

    public function store()
    {
        $this->validate([
            'type_id'=>'required',
            'des'=>'required',
            'amount'=>'required',
            'created_at'=>'required',
        ],[
            'type_id.required'=>'ໃສ່ປະເພດກ່ອນ!',
            'des.required'=>'ໃສ່ລາຍລະອຽດ!',
            'amount.required'=>'ໃສ່ຈຳນວນເງິນກ່ອນ!',
            'created_at.required'=>'ໃສ່ວັນທີ່ກ່ອນ!',
        ]);

        $expenses = new IncomeExpenses();
        $expenses->code = $this->code;
        $expenses->type_id = $this->type_id;
        $expenses->des = $this->des;
        $expenses->amount = str_replace(',','',$this->amount);
        $expenses->user_id = auth()->user()->id;
        $expenses->branch_id = auth()->user()->branchname->id;
        $expenses->created_at = $this->created_at;
        $expenses->save();

        $this->dispatchBrowserEvent('hide-modal-add');
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
    }

    public function edit($ids)
    {
        $this->dispatchBrowserEvent('show-modal-edit');

        $singleData = IncomeExpenses::find($ids);
        $this->hiddenId = $singleData->id; //un t 1 t trng sai
        $this->code = $singleData->code;
        $this->type_id = $singleData->type_id;
        $this->des = $singleData->des;
        $this->amount = $singleData->amount;
        $this->user_id = $singleData->user_id;
        $this->branch_id = $singleData->branch_id;
        $this->created_at = $singleData->created_at;
    }

    public function update()
    {
        //$this->validate();
        $ids = $this->hiddenId;
        $expenses = IncomeExpenses::find($ids);

            $expenses->code = $this->code;
            $expenses->type_id = $this->type_id;
            $expenses->des = $this->des;
            $expenses->amount = str_replace(',','',$this->amount);
            $expenses->user_id = auth()->user()->id;
            $expenses->branch_id = auth()->user()->branchname->id;
            $expenses->created_at = $this->created_at;

            $expenses->save();

            $this->dispatchBrowserEvent('hide-modal-edit');
            $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
            $this->resetField();
    }

        //Show and Delete 
    public function showDestroy($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = IncomeExpenses::find($ids);
        $this->hiddenId = $singleData->id;
    }
    public function destroy()
    {
        $ids = $this->hiddenId;
        $vihicle = IncomeExpenses::find($ids);
        $vihicle->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }
}

