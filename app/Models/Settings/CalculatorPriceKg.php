<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculatorPriceKg extends Model
{
    use HasFactory;

    protected $fillable = ['name','price_local','price_south','price_north','note'];
}
