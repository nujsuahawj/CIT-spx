<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeExpenses extends Model
{
    use HasFactory;
    protected $fillable = ['code','type_id','des','amount','file','user_id','branch_id','created_at'];

    public function username()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function branchname()
    {
        return $this->belongsTo('App\Models\Settings\Branch','branch_id','id');
    }
}
