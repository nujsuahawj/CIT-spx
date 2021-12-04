<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Settings\Packet;
use Illuminate\Support\Facades\Auth;
use DB;

class PacketComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $hiddenId,$code ,$name,$largs,$hieghs,$longs,$currency='LAK',$price,$status=1, $search;

    public function render()
    {
        $packets = Packet::orderBy('id','desc')
                        ->where(function($query){
                        $query->where('name', 'like', '%' .$this->search. '%')-> orwhere('code','like','%'.$this->search.'%') ;
                        })->paginate(10);

        return view('livewire.admin.settings.packet-component',compact('packets'))->layout('layouts.base');
    }

    public function store()
    {
        Packet::create([
            'code' => $this->code,
            'name' => $this->name,
            'largs'=>$this->largs,
            'hieghs'=>$this->hieghs,
            'longs'=>$this->longs,
            'currency_code'=> $this->currency,
            'price'=>$this->price,
            'status'=>$this->status
        ]);
   // $this->resetField();
      $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
    }
}
