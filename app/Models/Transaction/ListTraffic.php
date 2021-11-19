<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTraffic extends Model
{
    use HasFactory;
    protected $fillable = ['trf_code','rvcode','sender_unit','user_unit','add_date','sendto_unit','receive_date','user_receive','status','user_id','branch_id'];

    public function receive()
    {
        return $this->belongsTo('App\Models\Transaction\ReceiveTransaction','rvcode','code');
    }
    public function branch_send()
    {
        return $this->belongTo('App\Models\Settings\Branch','sender_unit','id');
    }
    public function send_to()
    {
        return $this->belongsTo('App\Models\Settings\Branch','sendto_unit','id');
    }
    public function user_receive()
    {
        return $this->belongTo('App\Models\User','user_receive','id');
    }
    public function username()
    {
        return $this->belongsTo('App\Models\User','user_create','id');
    }
    public function branchname()
    {
        return $this->belongsTo('App\Models\Settings\Branch','branch_id','id');
    }
}
