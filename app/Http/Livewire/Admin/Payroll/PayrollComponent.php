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

class PayrollComponent extends Component
{

    protected $paginationTheme = 'bootstrap';

    public $hidenId, $from_date, $search, $branch_search, $emp_id;

    public function render()
    {

        $employees = Employee::select('id','firstname','lastname')->orderBy('id','desc')->where('branch_id', auth()->user()->branchname->id)->where('del',1)->get();

        $allbranch = Branch::all();

        $payrolls = Payroll::orderBy('id','desc')->count();

        if(Auth()->user()->rolename->name == 'admin'){
            if(!empty($this->branch_search)){
                $payroll = Payroll::orderBy('id','desc')
                ->where('month','like', '%' .$this->search. '%')
                ->where('year','like', '%' .$this->search. '%')
                ->where('branch_id','like', '%' .$this->branch_search. '%')
                ->paginate(10);
            }else{
                $payroll = Payroll::orderBy('id','desc')
                ->where('month','like', '%' .$this->search. '%')
                ->where('year','like', '%' .$this->search. '%')
                ->paginate(10);
            }
            
        }else{
            $payroll = Payroll::orderBy('id','desc')
            ->where('code','like', '%' .$this->search. '%')
            ->where('month','like', '%' .$this->search. '%')
            ->where('year','like', '%' .$this->search. '%')
            ->where('branch_id', auth()->user()->branchname->id)
            ->paginate(10);
            }

        return view('livewire.admin.payroll.payroll-component', compact('payroll','payrolls','allbranch'))->layout('layouts.base');
    }
public function approved($id)
    {
        $approveds = Payroll::find($id);
        $approveds->approve_id = auth()->user()->id;
        $approveds->del = 1;
        $approveds->approve_date = date('Y-m-d');
        $approveds->save();

        $approveds_detail = PayrollDetail::where('payroll_id',$id)->get();
        foreach ($approveds_detail as $key => $value) {
            $paytrans = PayrollDetail::find($value->id);
            $paytrans->del = 1;
            $paytrans->updated_at = \Carbon\Carbon::now();
            $paytrans->save();
        }

        $this->emit('alert',['type' => 'success','message'=>'ອະນຸມັດສຳເລັດ!']);
    }
    public function showDelete($id)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $payroll = Payroll::find($id);
        $this->hidenId = $payroll->id;
    }
    public function editPayroll($id)
    {
        //dd($id);
        $payroll = Payroll::find($id);
        return redirect(route('admin.edit_payroll',$id));
    }
    public function deletePayroll()
    {
        $deleteId = $this->hidenId;
        $payroll = Payroll::find($deleteId);

        $payrollDetail = PayrollDetail::where('payroll_id',$deleteId)->delete();
        $payroll->delete();
        $this->emit('alert',['type' => 'success','message'=>'ລຶບລາຍການເງິນເດືອນອອກສຳເລັດ!']);
        $this->dispatchBrowserEvent('close-modal-delete');
    }

    //Payroll Detail
    public function payrollDetail($id)
    {
        $payroll = Payroll::find($id);
        return redirect(route('admin.payroll_detail', $id));
    }
    //Print payroll
    public function printA4Payroll($id)
    {
        $payroll = Payroll::find($id);
        return redirect(route('admin.printa4_payroll', $id));
    }
}
