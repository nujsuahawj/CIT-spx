<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipOutTransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = ['ship_out_id','receive_tran_id','goods_name','unit','amount'];

    public function receive_tran_name()
    {
        return $this->hasMany('App\Models\Transaction\ReceiveTransaction','receive_tran_id','id');
    }
}
