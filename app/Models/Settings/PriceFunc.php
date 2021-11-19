<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceFunc extends Model
{
    use HasFactory;
    protected $fillable = ['id','cal_price_id','currency_code','price'];
}
