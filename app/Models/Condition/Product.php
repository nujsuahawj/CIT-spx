<?php

namespace App\Models\Condition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['code','product_type_id','name','price','service_price','note'];

    public function productname()
    {
        return $this->belongsTo('App\Models\Condition\ProductType','product_type_id','id');
    }
}
