<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matterail extends Model
{
    use HasFactory;
    protected $fillable = ['id','code','receive_id','goods_id','distance_id','product_type_id','large','height','longs','weigh'
    ,'cal_id','currency_code','amout','paid_type','cod_amount','insur_amount','pack_id','pack_amount','branch_id','status'];

    public function goodname(){
        return $this->belongsTo('App\Models\Settings\GoodsType','goods_id','id');
    }

    public function productname(){
        return $this->belongsTo('App\Models\Condition\ProductType','product_type_id','id');
    }

    public function calculatename(){
        return $this->belongsTo('App\Models\Settings\CalculatePrice','cal_price_id','id');
    }

    public function distantname(){
        return $this->belongsTo('App\Models\Settings\Distance','distance_id','id');
    }

    public function receivename()
    {
        return $this->belongsTo('App\Models\Transaction\ReceiveTransaction','receive_id','code');
    }
    public function packname()
    {
        return $this->belongsTo('App\Models\Settings\Packet','pack_id','id');
    }
    														
}
