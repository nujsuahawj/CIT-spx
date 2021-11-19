<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    use HasFactory;
    protected $fillable =['id','code'];

    public function branch_send()
    {
        return $this->belongTo('App\Models\Settings\Branch','branch_send','id');
    }
    public function customername_send()
    {
        return $this->belongTo('App\Models\Condition\Customer','customer_send','id');
    }
    public function branch_receive()
    {
        return $this->belongTo('App\Models\Settings\Branch','branch_receive','id');
    }
    public function customername_receive()
    {
        return $this->belongTo('App\Models\Condition\Customer','customer_receive','id');
    }
    public function goodsname()
    {
        return $this->belongTo('App\Models\Settings\GoodsType','goods_type_id','id');
    }
    public function coculatename()
    {
        return $this->belongTo('App\Models\Settings\CoculateType','coculator_type_id','id');
    }
    public function paymenttypename()
    {
        return $this->belongTo('App\Models\Settings\PaymentType','payment_type_id','id');
    }
    public function paymentname()
    {
        return $this->belongTo('App\Models\Settings\Payment','payment_id','id');
    }
    public function shippingname()
    {
        return $this->belongTo('App\Models\Settings\Shipping','shipping_id','id');
    }
    public function username()
    {
        return $this->belongTo('App\Models\Settings\User','creator_id','id');
    }
    public function branch_create()
    {
        return $this->belongTo('App\Models\Settings\Branch','branch_create_id','id');
    }
}
