<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EwStm extends Model
{
    use HasFactory;
    protected $fillable = [ 'txcode','valuedt','ewid','acno','currency_code','action','amount','trcode','vcode','mcode','status','descs','branch_id','user_create'];
}
