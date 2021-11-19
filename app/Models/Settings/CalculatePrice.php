<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculatePrice extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','distance_id','func_type','cal_type_id','min_val','max_val','currency_code','price','branch_id','status','del'];
}
