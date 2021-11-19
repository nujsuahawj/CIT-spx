<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodClear extends Model
{
    use HasFactory;
    protected $fillable = ['id','valuedt','vcode','currency_code','cod_total','hdiq','branch_send','branch_recieve','clr_dt1','cl_dt2','clr_dt3','status','updated_at', 'created_at'];
}
