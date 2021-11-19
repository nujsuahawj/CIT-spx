<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ewallet extends Model
{
    use HasFactory;
    protected $fillable = ['id','acno','acname','branch_id','currency_code','balance','income','expend','image','status','user_create','updated_at', 'created_at'];
    
}
