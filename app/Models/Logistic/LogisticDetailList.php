<?php

namespace App\Models\Logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticDetailList extends Model
{
    use HasFactory;

    protected $fillable = ['id','lgt_id','detail_id','rvcode','code','good_id','product_type_id','large','height','longs','weigh','amount','paid_type','sendto_unit','user_id','branch_id','status'];

    public function logisname()
    {
        return $this->belongsTo('App\Models\Logistic\Logistic','lgt_id','id');
    }
    public function logisdetailname()
    {
        return $this->belongsTo('App\Models\Logistic\LogisticDetail','detail_id','id');
    }
    public function goodname(){
        return $this->belongsTo('App\Models\Settings\GoodsType','good_id','id');
    }
    public function productname()
    {
        return $this->belongsTo('App\Models\Condition\ProductType','product_type_id','id');
    }
    public function sendto()
    {
        return $this->belongsTo('App\Models\Settings\Branch','sendto_unit','id');
    }
    public function branchname()
    {
        return $this->belongsTo('App\Models\Settings\Branch','branch_id','id');
    }
    public function subsendto(){
        return $this->hasMany('App\Models\Logistic\LogisticDetailList','sendto_unit');
    }
}
