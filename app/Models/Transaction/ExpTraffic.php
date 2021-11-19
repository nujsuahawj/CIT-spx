<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpTraffic extends Model
{
    use HasFactory;
    protected $fillable = ['trf_code','exp_id','currency_code','amount','user_create','branch_id','date_create'];

    public function expendtypename()
    {
        return $this->belongsTo('App\Models\Transaction\ExpendType','exp_id','id');
    }
}
