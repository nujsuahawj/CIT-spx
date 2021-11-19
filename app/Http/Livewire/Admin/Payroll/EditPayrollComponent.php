<?php

namespace App\Http\Livewire\Admin\Payroll;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Staff\Employee;
use App\Models\Staff\Payroll;
use App\Models\Staff\PayrollDetail;
use App\Models\Staff\PayrollTransection;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use Carbon\Carbon;

class EditPayrollComponent extends Component
{


    public $hidenId, $bonus, $note, $month, $branch_id, $hiddenIdd;

    public function mount($id)
    {
        $editpayroll = Payroll::find($id);
        $this->hidenId = $editpayroll->id;
    }

    public function render()
    {

        $allbranch = Branch::all();
        $payrolltransections = PayrollTransection::all();
        $sum_total_amount = PayrollTransection::all()->sum('amount');
        $sum_total_bonus = PayrollTransection::all()->sum('bonus');

        $payrolls = Payroll::where('id', $this->hidenId)->first();
        $payrolldetails = PayrollDetail::where('payroll_id', $this->hidenId)->get();

        $sum_total_amounts = PayrollDetail::select('payroll_id','amount')->where('payroll_id', $this->hidenId)->sum('amount');
        $sum_total_bonuse = PayrollDetail::select('payroll_id','bonus')->where('payroll_id', $this->hidenId)->sum('bonus');

        return view('livewire.admin.payroll.edit-payroll-component',[
            'payrolltransections'=>$payrolltransections,'sum_total_amount'=>$sum_total_amount,'sum_total_bonus'=>$sum_total_bonus,'allbranch'=>$allbranch, 'payrolls'=>$payrolls, 'payrolldetails'=>$payrolldetails, 'sum_total_amounts'=>$sum_total_amounts, 'sum_total_bonuse'=>$sum_total_bonuse])->layout('layouts.base');
    }

 protected $rules = [
        'bonus'=>'required'
    ];
    protected $messages = [
        'bonus.required'=>'ກະລຸນາເພີ່ມເງິນໂບນັສກ່ອນ!'
    ];
    public function resetBonusForm()
    {
        $this->bonus = ''; $this->note = ''; 
    }

    public function addTolist()
    {
        $month = date('m', strtotime($this->month));
        $years = date('Y', strtotime($this->month));
        
        if(Auth()->user()->rolename->name == 'admin'){
            $this->validate([
                'month'=>'required',
                'branch_id'=>'required|unique:payroll_details'
            ],[
                'month.required'=>'ເລືອກເດືອນກ່ອນ!',
                'branch_id.required'=>'ເລືອກສາຂາກ່ອນ!',
                'branch_id.unique'=>'ສາຂານີ້ເພີ່ມແລ້ວ!',
            ]);

            $employee = Employee::select('id','saraly_type_id','branch_id','del')->where('del', 1)->where('branch_id',$this->branch_id)->get();
            foreach ($employee as $key => $value) {
            $payrollDetails = array(
                'payroll_id' => $this->hidenId,
                'emp_id'=>$value->id,
                'month'=>$month,
                'year'=>$years,
                'amount'=>$value->salaryhname->salary,
                'bonus'=>0,
                'branch_id' => $value->branch_id
            );
            $Payrolltransections = PayrollDetail::insert($payrollDetails);
            }
        }else{
            $this->validate([
                'month'=>'required',
                'branch_id'=>'unique:payroll_details'
            ],[
                'month.required'=>'ເລືອກເດືອນກ່ອນ!',
                'branch_id.unique'=>'ສາຂານີ້ເພີ່ມແລ້ວ!',
            ]);
            $employee = Employee::select('id','saraly_type_id','branch_id','del')->where('del', 1)->where('branch_id',Auth()->user()->branch_id)->get();
            foreach ($employee as $key => $value) {
            $payrollDetails = array(
                'payroll_id' => $this->hidenId,
                'emp_id'=>$value->id,
                'month'=>$month,
                'year'=>$years,
                'amount'=>$value->salaryhname->salary,
                'bonus'=>0,
                'branch_id' => $value->branch_id
            );
            $Payrolltransections = PayrollDetail::insert($payrollDetails);
            }
        }
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມສິນຄ້າສຳເລັດ!']);
    }


    //Show Bonus
    public function showBonus($ids)
    {
        $this->resetBonusForm();
        $this->dispatchBrowserEvent('show-modal-bonus');
        $singleData = PayrollDetail::find($ids);
        $this->hiddenIdd = $singleData->id;
        $this->bonus = $singleData->bonus;
        $this->note = $singleData->note;
    }
    public function saveBonus()
    {
        $this->validate();
        $ids = $this->hiddenIdd;
        $transection = PayrollDetail::find($ids);
        $transection->bonus = str_replace(',','',$this->bonus);
        $transection->note = $this->note;
        $transection->save();
        $this->dispatchBrowserEvent('hide-modal-bonus');
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມຂໍ້ມູນສຳເລັດ!']);
    }

    public function savePayroll()
    {
        $month = date('m', strtotime($this->month));
        $years = date('Y', strtotime($this->month));

        $sum_amount = PayrollDetail::all()->where('payroll_id', $this->hidenId)->sum('amount');
        $sum_bonus = PayrollDetail::all()->where('payroll_id', $this->hidenId)->sum('bonus');

        $payroll = Payroll::find($this->hidenId);
        $payroll->total_salary = $sum_amount;
        $payroll->total_bonus = $sum_bonus;
        $payroll->user_id = auth()->user()->id;
        $payroll->branch_id = auth()->user()->branchname->id;
        $payroll->approve_id = auth()->user()->id;
        $payroll->save();

        return redirect(route('admin.payroll'));
        $this->emit('alert',['type'=>'success','message'=>'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
    }
}
