<?php

namespace App\Models\Condition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['code','name','phone','email','address','bod','cus_type_id','branch_id','note','del','pro_id','dis_id','vil_id'];

    public function custype(){
        return $this->belongsTo('App\Models\Condition\CustomerType','cus_type_id','id');
    }
    public function branch(){
        return $this->belongsTo('App\Models\Settings\Branch','branch_id','id');
    }
    public function villname()
    {
        return $this->belongsTo('App\Models\Settings\Village','vil_id','id');
    }
    public function disname()
    {
        return $this->belongsTo('App\Models\Settings\District','dis_id','id');
    }
    public function proname()
    {
        return $this->belongsTo('App\Models\Settings\Province','pro_id','id');
    }
}
