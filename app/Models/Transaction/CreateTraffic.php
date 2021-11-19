<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateTraffic extends Model
{
    use HasFactory;
    protected $fillable = ['trf_code','vh_id','emp_id','user_create','branch_id','start_date','stop_date','status'];

    public function vihiclename()
    {
        return $this->belongsTo('App\Models\Condition\Vihicle','vh_id','id');
    }
    public function staffdoing()
    {
        return $this->belongsTo('App\Models\Staff\StaffDoing','emp_id','id');
    }
    public function username()
    {
        return $this->belongsTo('App\Models\User','user_create','id');
    }
    public function branchname()
    {
        return $this->belongsTo('App\Models\Settings\Branch','branch_id','id');
    }
}
