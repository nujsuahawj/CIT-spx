<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EwTran extends Model
{
    use HasFactory;
    protected $fillable = ['txid','txcode','valuedt','currency_code','amount1','amount2','amount3','code1','code2','code3','user_create','branch_id','status','descs','created_at'];
}
