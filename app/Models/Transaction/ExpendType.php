<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpendType extends Model
{
    use HasFactory;
    protected $fillable = ['exp_code','expend_name','currency_code','amount','user_create'];
}
