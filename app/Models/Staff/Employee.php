<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['code','firstname','lastname','bod','position_id','card_id','card_enddate','address','vill_id','dis_id','pro_id',
    'start_date','end_date','photo','file','status','note','user_id','branch_id'];

    public function villagename()
    {
        return $this->belongsTo('App\Models\Settings\Village','vill_id','id');
    }
    public function districtname()
    {
        return $this->belongsTo('App\Models\Settings\District','dis_id','id');
    }
    public function provincename()
    {
        return $this->belongsTo('App\Models\Settings\Province','pro_id','id');
    }
    public function salaryhname()
    {
        return $this->belongsTo('App\Models\Staff\SaralyType','position_id','id');
    }
    public function positionname()
    {
        return $this->belongsTo('App\Models\Settings\Staff\Position','position_id','id');
    }
    public function branchname()
    {
        return $this->belongsTo('App\Models\Settings\Branch','branch_id','id');
    }
    public function username()
    {
        return $this->belongsTo('App\Models\Settings\User','user_id','id');
    }
}
