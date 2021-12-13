<?php

namespace App\Http\Livewire\Admin\Traffic;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Transaction\ListTraffic;
use App\Models\Transaction\CreateTraffic;
use App\Models\Transaction\ExpTraffic;
use App\Models\Transaction\ExpendType;
use App\Models\Staff\StaffDoing;
use Illuminate\Support\Facades\Auth;
use DB;

class ViewTrafficComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $hiddenId, $trfcode, $traff_code;
    public function render()
    {
        $traffic = CreateTraffic::where('branch_id', Auth::user()->branchname->id)->orderBy('id','desc')->get();
        return view('livewire.admin.traffic.view-traffic-component',compact('traffic'))->layout('layouts.base');
    }

    public function editTraffic($ids)
    {
        return redirect(route('admin.edit_traffic',$ids));
    }

    public function showDelete($id)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $traffic = CreateTraffic::find($id);
        $this->hiddenId = $traffic->id;
        $this->trfcode = $traffic->trf_code;
    }
    public function deleteTraffic()
    {
        $deleteId = $this->hiddenId;
        $traffic = CreateTraffic::find($deleteId);
        $traffic->delete();
        $this->emit('alert',['type' => 'success','message'=>'ລຶບຂໍ້ມູນອອກສຳເລັດ!']);
        $this->dispatchBrowserEvent('close-modal-delete');
    }

    public function DetailTraffic($ids)
    {
        return redirect(route('admin.detail_traffic',$ids));
    }

    public function resetTraff()
    {
        if(!empty($this->traff_code)){
            $traff = CreateTraffic::where('status', 'S')->where('trf_code', $this->traff_code)->first();
            if(!empty($traff))
            {
                $resettraff = CreateTraffic::find($traff->id);
                $resettraff->status = "F";
                $resettraff->save();

                $staff = DB::table('staff_doings')->where('trf_code', $resettraff->trf_code)->update(array('status' => 'F'));

                $this->emit('alert', ['type' => 'success', 'message' => 'ການຂົນສົ່ງສຳເລັດ!']);
                $this->traff_code = '';
            }else{
                $this->emit('alert', ['type' => 'error', 'message' => 'ລາຍການນີ້ບໍ່ມີໃນລະບົບ!']);
                $this->traff_code = '';
            }
        }
    }
}
