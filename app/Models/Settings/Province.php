<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function districtname()
    {
        return $this->hasMany('App\Models\Settings\District','pro_id','id');
    }
}
