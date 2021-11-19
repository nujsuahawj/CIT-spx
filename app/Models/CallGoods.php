<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallGoods extends Model
{
    use HasFactory;
    protected $fillable =['id','code','goods_types_id','product_type_id','vihicle_type_id','product_count','large','height','longs','weight','detal','appoinment_time','longitude','latitude','note','user_id','status'];

    public function vihicletypename()
    {
        return $this->belongsTo('App\Models\Condition\VihicleType','vihicle_type_id','id');
    }

    public function username()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function goodTypename()
    {
        return $this->belongsTo('App\Models\Settings\GoodsType','goods_types_id','id');
    }

    public function productname(){
        return $this->belongsTo('App\Models\Condition\ProductType','product_type_id','id');
    }
}
