<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paydevidends extends Model
{
    use HasFactory;
    protected $fillable = ['id','count','amount','branch_id','user_id'];

    public function branchname()
    {
        return $this->belongsTo('App\Models\Settings\Branch','branch_id','id');
    }
    public function username()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
