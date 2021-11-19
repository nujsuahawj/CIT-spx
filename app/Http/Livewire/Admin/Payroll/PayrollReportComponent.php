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

class PayrollReportComponent extends Component
{

    public $hiddenId, $bonus, $note, $months, $years, $branch_search;
    
    public function render()
    {
        if(!empty($this->branch_search)){
            $allbranch = Branch::all();
            $month = Payroll::select('id','month')->get();
            $year = Payroll::select('id','year')->get();
            if(!empty($this->months)){
                if(!empty($this->years)){
                    $payrolldetails = PayrollDetail::where('branch_id', $this->branch_search)
                    ->where('month', 'like', '%' .$this->months. '%')
                    ->where('year', 'like', '%' .$this->years. '%')->where('del', 1)->get();
                    $sum_total_amount = PayrollDetail::all()->where('branch_id', $this->branch_search)
                    ->where('month', 'like', '%' .$this->months. '%')
                    ->where('year', 'like', '%' .$this->years. '%')->where('del', 1)->sum('amount');
                    $sum_total_bonus = PayrollDetail::all()->where('branch_id', $this->branch_search)
                    ->where('month', 'like', '%' .$this->months. '%')
                    ->where('year', 'like', '%' .$this->years. '%')->where('del', 1)->sum('bonus');
                }else{
                    $payrolldetails = PayrollDetail::where('branch_id', $this->branch_search)
                    ->where('month', 'like', '%' .$this->months. '%')->where('del', 1)->get();
                    $sum_total_amount = PayrollDetail::all()->where('branch_id', $this->branch_search)
                    ->where('month', 'like', '%' .$this->months. '%')->where('del', 1)->sum('amount');
                    $sum_total_bonus = PayrollDetail::all()->where('branch_id', $this->branch_search)
                    ->where('month', 'like', '%' .$this->months. '%')->where('del', 1)->sum('bonus');
                }
                
            }else{
                $payrolldetails = PayrollDetail::where('branch_id', $this->branch_search)->get();
                $sum_total_amount = PayrollDetail::all()->where('branch_id', $this->branch_search)
                ->where('del', 1)->sum('amount');
                $sum_total_bonus = PayrollDetail::all()->where('branch_id', $this->branch_search)
                ->where('del', 1)->sum('bonus');
            }
        }else{
            $allbranch = Branch::all();
            $payrolldetails = PayrollDetail::all()->where('del', 1);
            $month = Payroll::select('id','month')->get();
            $year = Payroll::select('id','year')->get();
            $sum_total_amount = PayrollDetail::all()->where('del', 1)->sum('amount');
            $sum_total_bonus = PayrollDetail::all()->where('del', 1)->sum('bonus');
        }

        return view('livewire.admin.payroll.payroll-report-component',[
            'payrolldetails'=>$payrolldetails,'month'=>$month,'year'=>$year,'sum_total_amount'=>$sum_total_amount,'sum_total_bonus'=>$sum_total_bonus,'allbranch'=>$allbranch])->layout('layouts.base');
    }
}
