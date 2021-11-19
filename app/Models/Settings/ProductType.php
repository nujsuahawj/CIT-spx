<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','goods_id','func_type','cal_price_id','parent_id','branch_id','status'];

    public function goodsmap()
    {
        return $this->belongsTo('App\Models\Settings\GoodsType','goods_id','id');
    }
   
}
