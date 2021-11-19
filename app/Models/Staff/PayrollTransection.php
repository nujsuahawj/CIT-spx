<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollTransection extends Model
{
    use HasFactory;

    protected $fillable = ['emp_id','month','year','amount','bonus','note','user_id','branch_id'];

    public function employeename()
    {
        return $this->belongsTo('App\Models\Staff\Employee','emp_id','id');
    }
    public function branchname()
    {
        return $this->belongsTo('App\Models\Settings\Branch','branch_id','id');
    }
    public function username()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

}
