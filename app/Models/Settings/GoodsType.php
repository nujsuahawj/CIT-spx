<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsType extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','parent_id','branch_id','status'];

    public function subcatalog(){
        return $this->hasMany('App\Models\Setting\GoodsType','parent_id');
    }
}
