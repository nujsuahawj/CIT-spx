<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculatorPriceOther extends Model
{
    use HasFactory;

    protected $fillable = ['name','condition1','condition2'];
}
