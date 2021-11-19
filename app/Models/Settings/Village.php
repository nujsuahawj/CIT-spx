<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    protected $fillable = ['name','dis_id','pro_id'];

    public function disname()
    {
        return $this->belongsTo('App\Models\Settings\District','dis_id','id');
    }

    public function proname()
    {
        return $this->belongsTo('App\Models\Settings\Province','pro_id','id');
    }
}
