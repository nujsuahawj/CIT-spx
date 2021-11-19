<?php

namespace App\Models\Logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticTransection extends Model
{
    use HasFactory;

   protected $fillable = ['id','trf_code','rvcode','sender_unit','user_unit','add_date','sendto_unit','user_receive','receive_date','status'];

    public function receive()
    {
        return $this->belongsTo('App\Models\Transaction\ReceiveTransaction','rvcode','code');
    }

    public function sender()
    {
        return $this->belongsTo('App\Models\Settings\Branch','sender_unit','id');
    }

    public function sendto()
    {
        return $this->belongsTo('App\Models\Settings\Branch','sendto_unit','id');
    }

    public function username()
    {
        return $this->belongsTo('App\Models\Settings\User','user_unit','id');
    }
}
