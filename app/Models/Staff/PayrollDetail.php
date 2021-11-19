<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollDetail extends Model
{
    use HasFactory;

    protected $fillable = ['payroll_id','emp_id','month','year','amount','bonus','note','branch_id'];

    public function payroll()
    {
        return $this->belongsTo('App\Models\Staff\Payroll','payroll_id','id');
    }
    public function employeename()
    {
        return $this->belongsTo('App\Models\Staff\Employee','emp_id','id');
    }
    public function branchname()
    {
        return $this->belongsTo('App\Models\Settings\Branch','branch_id','id');
    }
}
