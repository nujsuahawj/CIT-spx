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
    public $delId,$delname,$hiddenId=null,$code ,$name,$largs,$hieghs,$longs,$currency='LAK',$price,$status=1, $search, $disab=null;

    public function render()
    {
        $packets = Packet::orderBy('id','desc')
                        ->where(function($query){
                        $query->where('name', 'like', '%' .$this->search. '%')-> orwhere('code','like','%'.$this->search.'%') ;
                        })->paginate(10);

        return view('livewire.admin.settings.packet-component',compact('packets'))->layout('layouts.base');
    }

    public function resetField()
    {
        $this->code = null;
        $this->name=null;
        $this->largs=0;
        $this->hieghs=0;
        $this->longs=0;
        $this->price=0;
        $this->status=1;
        $this->hiddenId =null;
        $this->disab=null;
    }


    public function store()
    {
        if(empty($this->hiddenId))
        { 
            $this->validate([
                'code'=>'required|unique:packets','name'=>'required'
            ],[
                'code.required'=>'ໃສ່ຊື່ແຂວງກ່ອນ!',
                'code.unique'=>'code ມີໃນລະບົບແລ້ວ!',
                'name.required'=>'ກະລຸນາເລືອກປະເພດເຄື່ອງ!'
            ]);
    
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
            $this->resetField();
            $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);

        }
        else{

            $this->validate([
               'name'=>'required'
            ],[
                'name.required'=>'ກະລຸນາເລືອກປະເພດເຄື່ອງ!'
            ]);
            
           $packet = Packet::find($this->hiddenId);
           $packet->update([
               'name' => $this->name,
               'largs'=>$this->largs,
               'hieghs'=>$this->hieghs,
               'longs'=>$this->longs,
               'currency_code'=> $this->currency,
               'price'=>$this->price,
               'status'=>$this->status
               ]);
               $this->resetField();
               $this->emit('alert', ['type' => 'success', 'message' => 'ແກ້ໄຂຂໍ້ມູນສຳເລັດ!']);



        }
        
    }

    
    public function edit($ids)
    {
        $singleData = Packet::find($ids);
        $this->code = $singleData->code;
        $this->name = $singleData->name;
        $this->largs = $singleData->largs;
        $this->hieghs=$singleData->hieghs;
        $this->longs = $singleData->longs;
        $this->price = $singleData->price;
        $this->status = $singleData->status;
        $this->hiddenId = $singleData->id;
        $this->disab='Disabled';
    }

    public function showDestroy($ids)
    {
        //dd($ids)
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = Packet::find($ids);
        $this->delId = $singleData->id;
        $this->delname=$singleData->name;

    }

    public function destroy($ids)
    {
       
        $branchtype = Packet::find($ids);
        $branchtype->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }

}
