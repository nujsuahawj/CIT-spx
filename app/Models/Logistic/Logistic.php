<?php

namespace App\Models\Logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logistic extends Model
{
    use HasFactory;
    
    protected $fillable = ['id','code','trf_code','create_date','user_create','branch_id','status'];

    public function trafficname()
    {
        return $this->belongsTo('App\Models\Transaction\CreateTraffic','trf_code','id');
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
