<?php

namespace App\Http\Livewire\Admin\Employee;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use App\Models\Settings\Province;
use App\Models\Settings\District;
use App\Models\Settings\Village;
use App\Models\Staff\Employee;
use App\Models\Staff\SaralyType;
use App\Models\Staff\Payroll;
use App\Models\Staff\PayrollDetail;
use App\Models\Staff\PayrollTransection;

class EmployeeDetailComponent extends Component
{
    public $hidenId;

    public function mount($id)
    {
        $employees = Employee::find($id);
        $this->hidenId = $employees->id;
    }
    public function render()
    {
        $employees = Employee::where('id', $this->hidenId)->first();
        return view('livewire.admin.employee.employee-detail-component', compact('employees'))->layout('layouts.base');
    }
}
