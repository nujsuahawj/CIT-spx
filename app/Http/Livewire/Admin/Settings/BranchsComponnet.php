<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Settings\Branch;
use App\Models\Settings\BranchType;
use App\Models\Settings\Dividend;
use App\Models\Settings\Tax;
use App\Models\Settings\Province;
use App\Models\Settings\District;
use App\Models\Settings\Village;
use App\Models\User;
use App\Models\Staff\Employee;
use Livewire\WithPagination;

class BranchsComponnet extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search=null;
    public function render()
    {
        if($this->search==null){
        $branch = Branch::where('del',1)->orderBy('id','desc')->paginate(10);
        }else{
            $branch = Branch::where('del',1)->orderBy('id','desc')
            ->where(function($query){
                $query->where('code', 'like', '%' .$this->search. '%')->orWhere('phone', 'like', '%' .$this->search. '%')->orWhere('company_name_la', 'like', '%' .$this->search. '%')->orWhere('company_name_en', 'like', '%' .$this->search. '%');
             })->orderBy('id','desc')->paginate(10);

        }
        return view('livewire.admin.settings.branchs-componnet', compact('branch'))->layout('layouts.base');
    }

    public function delete($id)
    {
        $branch = Branch::findOrFail($id);
        $result = $branch->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }
}
