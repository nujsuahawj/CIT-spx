<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = ['code','month','year','total_saraly','total_bonus','note','branch_id','user_id','approve_id'];

    public function branchname()
    {
        return $this->belongsTo('App\Models\Settings\Branch','branch_id','id');
    }
    public function username()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function approvedname()
    {
        return $this->belongsTo('App\Models\User','approve_id','id');
    }
}
