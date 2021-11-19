<?php

namespace App\Models\Condition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['code','name','phone','email','address','bod','cus_type_id','branch_id','note','del'];

    public function custype(){
        return $this->belongsTo('App\Models\Condition\CustomerType','cus_type_id','id');
    }
    public function branch(){
        return $this->belongsTo('App\Models\Settings\Branch','branch_id','id');
    }
}
