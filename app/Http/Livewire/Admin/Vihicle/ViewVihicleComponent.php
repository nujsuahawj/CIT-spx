<?php

namespace App\Http\Livewire\Admin\Vihicle;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use App\Models\Condition\Vihicle;
use App\Models\Condition\VihicleType;
use Illuminate\Http\Request;
use DB;

class ViewVihicleComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $hiddenId  , $name, $search,$search_by_date,$search_by_brc=0;
    public $code, $vihicletypename, $plate, $series, $power, $road_fee_date, $technic_date, $insurance_date, $note, $image;

    public function mount()
    {
        $this->code = $code = 'CIT'.date('Ymdms');

    }

    public function render()
    {
        
        $vihicletype = VihicleType::where('status',1)->get();

        if($this->search_by_brc==0){

            $vihicle=Vihicle::select('*')
            ->where(function($query){
                $query->where('vihicles.code', 'like', '%' .$this->search. '%','or','vihicles.plate_number','like','%'.$this->search.'%');
             })->paginate(10);

        }
        else{

            $vihicle=Vihicle::select('*')
            ->where(function($query){
                $query->where('vihicles.code', 'like', '%' .$this->search. '%')->orwhere('vihicles.plate_number','like','%'.$this->search.'%');
             })->where('vihicles.vihicle_type_id', 'like', '%' .$this->search_by_brc. '%')
             ->paginate(10);
        }

        return view('livewire.admin.vihicle.view-vihicle-component',compact('vihicle','vihicletype'))->layout('layouts.base');
    }
    public function resetField()
    {
        $this->name = '';
        $this->vihicletypename = '';
        $this->plate = '';
        $this->series = '';
        $this->power = '';
        $this->note = '';
        $this->photo = "";

    }

    public function create(){

        $this->resetField();
        $this->dispatchBrowserEvent('show-modal-add');
    }

    public function store()
    {
        $this->validate([
            'name'=>'required',
            'plate'=>'required',
            'series'=>'required',
        ],[
            'name.required'=>'ໃສ່ຊື່ກ່ອນ!',
            'plate.required'=>'ໃສ່ທະບຽນລົດກ່ອນ!',
            'series.required'=>'ໃສ່ເລກຖັງກ່ອນ!',
        ]);

        $vihicle = new Vihicle();
        $vihicle->code = $this->code;
        $vihicle->name = $this->name;
        $vihicle->vihicle_type_id = $this->vihicletypename;
        $vihicle->plate_number = $this->plate;
        $vihicle->series_number = $this->series;
        $vihicle->power_number = $this->power;
        $vihicle->road_fee_date = $this->road_fee_date;
        $vihicle->technic_date = $this->technic_date;
        $vihicle->note = $this->note;
        if($this->image == ""){
            $vihicle->photo = "";
        }else{
            $vihicle->photo = $this->image->store('upload/vihicle');
        }
        $vihicle->save();

        $this->dispatchBrowserEvent('hide-modal-add');
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
        $this->resetField();
    }

        //Show and Update 
    public function edit($ids)
    {
        $this->dispatchBrowserEvent('show-modal-edit');

        $singleData = Vihicle::find($ids);
        $this->hiddenId = $singleData->id; //un t 1 t trng sai
        $this->code = $singleData->code;
        $this->name = $singleData->name;
        $this->vihicletypename = $singleData->vihicle_type_id;
        $this->plate = $singleData->plate_number;
        $this->series = $singleData->series_number;
        $this->power = $singleData->power_number;
        $this->road_fee_date = $singleData->road_fee_date;
        $this->technic_date = $singleData->technic_date;
        $this->note = $singleData->note;

    }
    
    public function update()
    {
        //$this->validate();
        $ids = $this->hiddenId;
        $vihicle = Vihicle::find($ids);

            $vihicle->code = $this->code;
            $vihicle->name = $this->name;
            $vihicle->vihicle_type_id = $this->vihicletypename;
            $vihicle->plate_number = $this->plate;
            $vihicle->series_number = $this->series;
            $vihicle->power_number = $this->power;
            $vihicle->road_fee_date = $this->road_fee_date;
            $vihicle->technic_date = $this->technic_date;
            $vihicle->note = $this->note; 
            if($this->image == ""){
                $vihicle->photo = "";
            }else{
                $vihicle->photo = $this->image->store('upload/vihicle');
            }
            $vihicle->save();

            $this->dispatchBrowserEvent('hide-modal-edit');
            $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
            $this->resetField();
    }

        //Show and Delete 
    public function showDestroy($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = Vihicle::find($ids);
        $this->hiddenId = $singleData->id;
    }
    public function destroy()
    {
        $ids = $this->hiddenId;
        $vihicle = Vihicle::find($ids);
        $vihicle->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }

}

