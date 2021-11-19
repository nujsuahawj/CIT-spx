<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;
    protected $fillable = ['ex_date','currency_one','rate_one','currency_two','rate_two','result'];
}
