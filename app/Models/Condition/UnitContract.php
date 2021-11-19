<?php

namespace App\Models\Condition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitContract extends Model
{
    use HasFactory;

    protected $fillable = ['code','name','branch_id','branch_type_id','amount','start_date','end_date','file','note','user_id','status'];

    public function branchtypename()
    {
        return $this->belongsTo('App\Models\Settings\BranchType','branch_type_id','id');
    }
    public function branchname()
    {
        return $this->belongsTo('App\Models\Settings\Branch','branch_id','id');
    }
    public function username()
    {
        return $this->belongsTo('App\Models\User','user_create','id');
    }
}
