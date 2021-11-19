<?php

namespace App\Models\Logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticDetail extends Model
{
    use HasFactory;

   protected $fillable = ['id','lgt_id','trf_code','rvcode','sender_unit','user_unit','add_date','user_receive','receive_date','status'];

   public function trafficname()
   {
       return $this->belongsTo('App\Models\Transaction\CreateTraffic','trf_code','id');
   }
    public function logisname()
    {
        return $this->belongsTo('App\Models\Logistic\Logistic','lgt_id','id');
    }
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
        return $this->belongsTo('App\Models\User','user_unit','id');
    }
}
