<?php

namespace App\Models\Condition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','goods_id','func_type','cal_type_id','parent_id','status'];

    public function subcatalog(){
        return $this->hasMany('App\Models\Condition\ProductType','parent_id');
    }
}
