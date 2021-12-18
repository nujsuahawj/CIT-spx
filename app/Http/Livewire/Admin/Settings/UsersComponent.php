<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\User;
use App\Models\Settings\Branch;
use App\Models\Settings\Role;
use App\Models\Settings\Employee;
use App\Models\Transaction\ReceiveTransaction;
use Livewire\WithPagination;

class UsersComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search=null;

    public function render()
    {
        if($this->search==null){
        $user = User::orderBy('id','desc')->where('del',1)->paginate(10);
        }else{
            $user = User::where('del',1)->orderBy('id','desc')
            ->where(function($query){
                $query->where('name', 'like', '%' .$this->search. '%')->orWhere('phone', 'like', '%' .$this->search. '%')->orWhere('email', 'like', '%' .$this->search. '%');
             })->orderBy('id','desc')->paginate(10);
        }
        return view('livewire.admin.settings.users-component', compact('user'))->layout('layouts.base');
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $result = $user->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }
}
