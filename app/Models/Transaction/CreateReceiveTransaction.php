<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateReceiveTransaction extends Model
{
    use HasFactory;
    protected $fillable = ['id','code','branch_send','customer_send','	branch_receive','customer_receive','pro_id','dis_id','vil_id','amount','image','creator_id','branch_create_id','note','status'];
}
