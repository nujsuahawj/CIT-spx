<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffDoing extends Model
{
    use HasFactory;
    protected $fillable = ['id','trf_code','staff_id','status'];

    public function employeename()
    {
        return $this->belongsTo('App\Models\Staff\Employee','staff_id','id');
    }
}
