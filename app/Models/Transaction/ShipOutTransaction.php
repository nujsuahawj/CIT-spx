<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipOutTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['code','shipout_date','vihicle_id','emp_id','total_goods','shipping_id','creator_id','note'];

    public function vihiclename()
    {
        return $this->belongsTo('App\Condition\Vihicle','vihicle_id','id');
    }
    public function emname()
    {
        return $this->belongsTo('App\Staff\Employee','emp_id','id');
    }
    public function shippingname()
    {
        return $this->belongsTo('App\Settings\Shipping','shipping_id','id');
    }
    public function username()
    {
        return $this->belongsTo('App\Settings\User','creator_id','id');
    }
}
