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

class PayrollPrintComponent extends Component
{

    public $hidenId;

    public function mount($id)
    {
        $payrolls = Payroll::find($id);
        $this->hidenId = $payrolls->id;
    }

    public function render()
    {
        $payrolls = Payroll::where('id', $this->hidenId)->first();
        $payrolldetails = PayrollDetail::where('payroll_id', $this->hidenId)->get();

        $sum_total_amount = PayrollDetail::select('payroll_id','amount')->where('payroll_id', $this->hidenId)->sum('amount');
        $sum_total_bonus = PayrollDetail::select('payroll_id','bonus')->where('payroll_id', $this->hidenId)->sum('bonus');
        
        return view('livewire.admin.payroll.payroll-print-component', compact('payrolls','payrolldetails','sum_total_amount','sum_total_bonus'))->layout('layouts.base');
    }
}
