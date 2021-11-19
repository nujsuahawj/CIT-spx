<?php

namespace App\Http\Livewire\Admin\Traffic;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\CreateTraffic;
use App\Models\Transaction\ExpendType;
use App\Models\Staff\Employee;
use App\Models\Staff\StaffDoing;
use App\Models\Condition\Vihicle;
use Illuminate\Http\Request;
use DB;

class EditTrafficComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $code, $emp_id, $startDate, $billReceive, $search, $receive_code, $vihicle_id;

    public $hiddenIdStaff, $hiddenIdExpend, $hiddenIdTraffic;

    public function mount($id)
    {
        $max = CreateTraffic::find($id);
        $this->hiddenIdTraffic = $max->id;
        $this->code = $max->trf_code;
        $this->vihicle_id = $max->vh_id;
        $this->startDate = $max->start_date;
    }

    public function render()
    {
        $employee = Employee::orderBy('id')->get();
        $empdoing = StaffDoing::where('trf_code', $this->code)->orderBy('id')->get();
        $expend = ExpendType::where('exp_code', $this->code)->orderBy('id')->get();
        $vihicle = Vihicle::orderBy('id')->get();
        return view('livewire.admin.traffic.edit-traffic-component', compact('employee','empdoing','expend','vihicle'))->layout('layouts.base');
    }

public function addEmpDoing()
    {

        $emp = StaffDoing::where('trf_code', $this->code)->where('staff_id', $this->emp_id)->first();
        if(empty($emp)){
            $this->validate([
                'emp_id'=>'required'
            ],[
                'emp_id.required'=>'ກຸລະນາເລືອກ ພະນັກງານຂົນສົ່ງ ກ່ອນ!',
            ]);
            $staff = StaffDoing::where('staff_id', $this->emp_id)->where('status', 'W')->first();
            if(empty($staff)){
                $staff_doing = StaffDoing::create([
                    'trf_code'=> $this->code,
                    'staff_id'=> $this->emp_id,
                    'status'=>'W'
                ]);
                $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມ ພະນັກງານຂົນສົ່ງ ສຳເລັດ!']);
            }else{
                $this->emit('alert', ['type' => 'error', 'message' => 'ພະນັກງານ ຄົນນີ້ ກຳລັງຄົນສົ່ງ!']);
            }
        }else{
            $this->emit('alert', ['type' => 'warning', 'message' => 'ທ່ານໄດ້ເພີ່ມ ພະນັກງານ ຄົນນີ້ແລ້ວ!']);
        }
        
    }

    public $emp_name;

    public function showdestroyEmp($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete-employee');
        $singleData = StaffDoing::find($ids);
        $this->hiddenIdStaff = $ids;
        $this->emp_name = $singleData->employeename->firstname.' '.$singleData->employeename->lastname;
        // dd($this->emp_name);
    }

    public function destroyStaff($ids)
    {
        $singleData = StaffDoing::find($ids);
        $singleData->delete();
        $this->emit('alert', ['type' => 'success', 'message' => 'ລົບ ພະນັກງານຂົນສົ່ງ ສຳເລັດ!']);
        $this->dispatchBrowserEvent('hide-modal-delete-employee');
    }

    public $expendname, $expendamount;

    public function resetExpend()
    {
      $this->expendname = '';
      $this->expendamount = '';
    }

    public function showaddExpendTraf()
    {
        $this->dispatchBrowserEvent('show-modal-add-expend');
    }

    public function storeExpend()
    {
        $this->validate([
            'expendname'=>'required',
            'expendamount'=>'required'
        ],[
            'expendname.required'=>'ກຸລະນາເພີ່ມ ລາຍຈ່າຍ ກ່ອນ!',
            'expendamount.required'=>'ກຸລະນາເພີ່ມ ຈຳນວນເງິນ ກ່ອນ!',
        ]);
        $expend = new ExpendType;
        $expend->exp_code = $this->code;
        $expend->expend_name = $this->expendname;
        $expend->currency_code = 'LAK';
        $expend->amount = str_replace(',','',$this->expendamount);
        $expend->user_create = auth()->user()->id;
        $expend->branch_id = auth()->user()->branchname->id;
        $expend->created_at = \Carbon\Carbon::now();
        $expend->updated_at = \Carbon\Carbon::now();
        $expend->save();
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມ ລາຍຈ່າຍ ສຳເລັດ!']);
        $this->dispatchBrowserEvent('hide-modal-add-expend');
    }

    public function showEditExpend($ids)
    {
        $this->dispatchBrowserEvent('show-modal-edit-expend');
        $expend = ExpendType::find($ids);
        $this->hiddenIdExpend = $expend->id;
        $this->expendname = $expend->expend_name;
        $this->expendamount = number_format($expend->amount);
    }
    public function editExpend($ids)
    {
        $expend = ExpendType::find($ids);
        $expend->expend_name = $this->expendname;
        $expend->currency_code = 'LAK';
        $expend->amount = str_replace(',','',$this->expendamount);
        $expend->user_create = auth()->user()->id;
        $expend->branch_id = auth()->user()->branchname->id;
        $expend->updated_at = \Carbon\Carbon::now();
        $expend->save();
        $this->emit('alert', ['type' => 'success', 'message' => 'ແກ້ໄຂ ລາຍຈ່າຍ ສຳເລັດ!']);
        $this->dispatchBrowserEvent('hide-modal-edit-expend');
    }
    public function showDestroyExpend($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete-expend');
        $expend = ExpendType::find($ids);
        $this->hiddenIdExpend = $expend->id;
        $this->expendname = $expend->expend_name;
    }
    public function destroyExpend($ids)
    {
        
        $expend = ExpendType::find($ids);
        $expend->delete();
        $this->emit('alert', ['type' => 'success', 'message' => 'ລົບ ລາຍຈ່າຍ ສຳເລັດ!']);
        $this->dispatchBrowserEvent('hide-modal-delete-expend');
    }

    public function savebill()
    {
        $this->validate([
            'vihicle_id'=>'required',
            'startDate'=>'required'
        ],[
            'vihicle_id.required'=>'ກຸລະນາເລືອກ ລົດຂົນສົ່ງ ກ່ອນ!',
            'startDate.required'=>'ກຸລະນາເລືອກ ວັນທີເດີນທາງ ກ່ອນ!',
        ]);

        $st_doing = StaffDoing::where('trf_code', $this->code)->first();

            if(!empty($st_doing))
            {
                $vihi = CreateTraffic::where('vh_id', $this->vihicle_id)->whereIn('status', ['S','E'])->first();
                if(empty($vihi)){
                    $traff = new CreateTraffic;
                    $traff->trf_code = $this->code;
                    $traff->vh_id = $this->vihicle_id;
                    $traff->user_create = auth()->user()->id;
                    $traff->branch_id = auth()->user()->branchname->id;
                    $traff->start_date = $this->startDate;
                    $traff->status = 'E';
                    $traff->save();
                    $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
                    $this->resetTraffic();
                }else{
                    $this->emit('alert', ['type' => 'error', 'message' => 'ລົດຄັນດັ່ງກ່າວແມ່ນກຳລັງຂົນສົ່ງ! ກະລຸນາເລືອກຄັນອື່ນ!']);
                }
            }else{
                $this->emit('alert', ['type' => 'error', 'message' => 'ກະລຸນາເລືອກ ພະນັກງານຂົນສົ່ງ ກ່ອນ!']);
            }
    }
}
