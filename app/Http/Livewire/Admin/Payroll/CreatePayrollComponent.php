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

class CreatePayrollComponent extends Component
{

    public $hiddenId, $bonus, $note, $month, $branch_id;

    public function render()
    {
        $allbranch = Branch::all();
        $payrolltransections = PayrollTransection::all();
        $sum_total_amount = PayrollTransection::all()->sum('amount');
        $sum_total_bonus = PayrollTransection::all()->sum('bonus');
        return view('livewire.admin.payroll.create-payroll-component',[
            'payrolltransections'=>$payrolltransections,'sum_total_amount'=>$sum_total_amount,'sum_total_bonus'=>$sum_total_bonus,'allbranch'=>$allbranch])->layout('layouts.base');
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
                'branch_id'=>'required|unique:payroll_transections'
            ],[
                'month.required'=>'ເລືອກເດືອນກ່ອນ!',
                'branch_id.required'=>'ເລືອກສາຂາກ່ອນ!',
                'branch_id.unique'=>'ສາຂານີ້ເພີ່ມແລ້ວ!',
            ]);
            $employee = Employee::select('id','position_id','branch_id','del')->where('del', 1)->where('branch_id',$this->branch_id)->get();
            foreach ($employee as $key => $value) {
            $payrollDetails = array(
                'emp_id'=>$value->id,
                'month'=>$month,
                'year'=>$years,
                'amount'=>$value->salaryhname->salary,
                'bonus'=>0,
                'user_id' => auth()->user()->id,
                'branch_id' => $value->branch_id
            );
            $Payrolltransections = PayrollTransection::insert($payrollDetails);
            }
        }else{
            $this->validate([
                'month'=>'required',
            ],[
                'month.required'=>'ເລືອກເດືອນກ່ອນ!',
            ]);
            $employee = Employee::select('id','position_id','branch_id','del')->where('del', 1)->where('branch_id',Auth()->user()->branch_id)->get();
            foreach ($employee as $key => $value) {
            $payrollDetails = array(
                'emp_id'=>$value->id,
                'month'=>$month,
                'year'=>$years,
                'amount'=>$value->salaryhname->salary,
                'bonus'=>0,
                'user_id' => auth()->user()->id,
                'branch_id' => $value->branch_id
            );
            $Payrolltransections = PayrollTransection::insert($payrollDetails);
            }
        }
        
        
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມສິນຄ້າສຳເລັດ!']);

    }


    //Show Bonus
    public function showBonus($ids)
    {
        $this->resetBonusForm();
        $this->dispatchBrowserEvent('show-modal-bonus');
        $singleData = PayrollTransection::find($ids);
        $this->hiddenId = $singleData->id;
        $this->bonus = $singleData->bonus;
        $this->note = $singleData->note;
    }
    public function saveBonus()
    {
        $this->validate();
        $ids = $this->hiddenId;
        $transection = PayrollTransection::find($ids);
        $transection->bonus = str_replace(',','',$this->bonus);
        $transection->note = $this->note;
        $transection->save();
        $this->dispatchBrowserEvent('hide-modal-bonus');
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມຂໍ້ມູນສຳເລັດ!']);
    }

    public function showDeleteList($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $payrolllist = PayrollTransection::find($ids);
        $this->hiddenId = $payrolllist->branch_id;
    }

    public function deletePayrollList()
    {
        $deleteId = $this->hiddenId;
        $payrollDetail = PayrollTransection::where('branch_id',$deleteId)->delete();
        $this->emit('alert',['type' => 'success','message'=>'ລຶບລາຍການເງິນເດືອນອອກສຳເລັດ!']);
        $this->dispatchBrowserEvent('close-modal-delete');
    }

    public function savePayroll()
    {
        $this->validate([
            'month'=>'required',
        ],[
            'month.required'=>'ເລືອກເດືອນກ່ອນ!',
        ]);
        $month = date('m', strtotime($this->month));
        $years = date('Y', strtotime($this->month));

        $sum_amount = PayrollTransection::all()->sum('amount');
        $sum_bonus = PayrollTransection::all()->sum('bonus');

        $payroll = new Payroll();
        $payroll->code = 'LVM'.date('Ymdhms');
        $payroll->month = $month;
        $payroll->year = $years;
        $payroll->total_salary = $sum_amount;
        $payroll->total_bonus = $sum_bonus;
        $payroll->user_id = auth()->user()->id;
        $payroll->branch_id = auth()->user()->branchname->id;
        $payroll->approve_id = auth()->user()->id;
        $payroll->note = '';
        $payroll->save();

        $paytrans = PayrollTransection::get();
        foreach ($paytrans as $key => $value) {
            $payrollDetails = array(
                'payroll_id'=>$payroll->id,
                'emp_id'=>$value->emp_id,
                'month'=>$value->month,
                'year'=>$value->year,
                'amount'=>$value->amount,
                'bonus'=>$value->bonus,
                'note'=>$value->note,
                'branch_id'=>$value->branch_id,
                'created_at'=> \Carbon\Carbon::now(),
                'updated_at'=> \Carbon\Carbon::now()
            );
            
            $paytrans = PayrollDetail::insert($payrollDetails);
            $deleteTrans = PayrollTransection::where('id', $value->id)->delete();
        }

        return redirect(route('admin.payroll'));
        $this->emit('alert',['type'=>'success','message'=>'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
    }
}
