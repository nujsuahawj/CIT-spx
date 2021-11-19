<?php

namespace App\Models\Condition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vihicle extends Model
{
    use HasFactory;

    protected $fillable = ['code','name','vihicle_type_id','plate_number','series_number','power_number','road_fee_date','technic_date','insurance_date','note','active','plate_pic'];

    public function vihicletypename()
    {
        return $this->belongsTo('App\Models\Condition\VihicleType','vihicle_type_id','id');
    }
}
