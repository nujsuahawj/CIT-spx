<?php

namespace App\Http\Livewire\Admin\Traffic;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\ListTraffic;
use App\Models\Transaction\CreateTraffic;
use App\Models\Transaction\ExpTraffic;
use App\Models\Transaction\ExpendType;
use App\Models\Transaction\IncomeExpenses;
use App\Models\Transaction\ReceiveTransaction;
use App\Models\Transaction\Matterail;
use App\Models\Staff\Employee;
use App\Models\Staff\StaffDoing;
use App\Models\Condition\Vihicle;
use Illuminate\Http\Request;
use DB;

class CreateTrafficComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $code, $emp_id, $startDate, $billReceive, $search, $receive_code, $vihicle_id, $traff_code;

    public $hiddenIdStaff, $hiddenIdExpend, $hiddenIdTraffic;

    public function mount()
    {
        $max = CreateTraffic::max('id');
        // dd($max);
        $new = 0;
        if(!empty($max)){
            $this->code = 'TF00'.($max + 1);
        }else{
            $this->code = 'TF00'.($new + 1);
        }
    }

    public function render()
    {
        $employee = Employee::whereIn('position_id', [2,7])->orderBy('id','desc')->get();
        $empdoing = StaffDoing::where('trf_code', $this->code)->orderBy('id','desc')->get();
        $expend = ExpendType::where('exp_code', $this->code)->orderBy('id','desc')->get();
        $vihicle = Vihicle::orderBy('id','desc')->get();

        return view('livewire.admin.traffic.create-traffic-component', compact('employee','empdoing','expend','vihicle'))->layout('layouts.base');
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
        $this->resetExpend();
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
        $this->resetExpend();
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

    public $trfcode;

    public function showDestroyTraffic($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete-traffic');
        $traffic = ListTraffic::find($ids);
        $this->hiddenIdTraffic = $traffic->id;
        $this->trfcode = $traffic->trf_code;
    }

    public function destroyTraffic($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete-traffic');
        $traffic = ListTraffic::find($ids);
        $traffic->delete();
        $this->emit('alert', ['type' => 'success', 'message' => 'ລົບ ລາຍການ ສຳເລັດ!']);
        $this->dispatchBrowserEvent('hide-modal-delete-traffic');
    }

    public function showbillReceiveDetail()
    {
        $this->dispatchBrowserEvent('show-modal-bill-receive-detail');
    }

    public function addTraffic($ids)
    {
            $transaction = ReceiveTransaction::find($ids);
            if(!empty($transaction))
            {
                $traffic = new ListTraffic;
                $traffic->trf_code = $this->code;
                $traffic->rvcode = $transaction->code;
                $traffic->sender_unit = $transaction->branch_send;
                $traffic->user_unit = Auth()->user()->id;
                $traffic->add_date = date('Y-m-d');
                $traffic->start_date = $this->startDate;
                $traffic->status = 'S';
                $traffic->save();

                $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມ ລາຍການ ສຳເລັດ!']);
            }else{
                $this->emit('alert', ['type' => 'error', 'message' => 'ລາຍການນີ້ບໍ່ມີໃນລະບົບ!']);
            }
    }

    public function showDetailTraffic($ids)
    {
        $this->dispatchBrowserEvent('show-modal-receive-detail');
        $this->receive_code = $ids;
    }

    public function resetTraffic()
    {
        $max = CreateTraffic::max('id');
        $this->code = 'TF00'.($max + 1);
        $this->vihicle_id = '';
        $this->startDate = '';
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
                    $traff->start_date = $this->startDate.' '.date('h:i:s');
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
