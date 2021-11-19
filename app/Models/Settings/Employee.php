<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['code','firstname','lastname','bod','position_id','card_id','address','vill_id','dis_id','pro_id','start_date','end_date','photo','file','status','note','user_id'];
}
