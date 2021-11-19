<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiveTransaction extends Model
{
    use HasFactory;

    //protected $fillable = ['code','branch_send','customer_send','branch_receive','customer_receive','goods_type_id','goods_name','coculator_type_id','unit','amount',
   // 'image','payment_type_id','payment_id','shipping_id','creator_id','note','branch_create_id'];

   protected $fillable = ['id','code','type','valuedt','branch_send','customer_send','branch_receive','customer_receive','pro_id','dis_id','vil_id','currency_code','amount','service_type','cod_amount','insur','insur_rate','insur_amount','paid_by','image','creator_id','branch_create_id','deliver_id','deliver_date','note','status'];

    public function branch_sends()
    {
        return $this->belongsTo('App\Models\Settings\Branch','branch_send','id');
    }
    public function customername_send()
    {
        return $this->belongsTo('App\Models\Condition\Customer','customer_send','id');
    }
    public function branch_receive_name()
    {
        return $this->belongsTo('App\Models\Settings\Branch','branch_receive','id');
    }
    public function customername_receive()
    {
        return $this->belongsTo('App\Models\Condition\Customer','customer_receive','id');
    }
    public function goodsname()
    {
        return $this->belongsTo('App\Models\Settings\GoodsType','goods_type_id','id');
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
        return $this->belongsTo('App\Models\User','creator_id','id');
    }
    public function branch_create()
    {
        return $this->belongsTo('App\Models\Settings\Branch','branch_create_id','id');
    }
    public function delivername()
    {
        return $this->belongsTo('App\Models\User','deliver_id','id');
    }
}
