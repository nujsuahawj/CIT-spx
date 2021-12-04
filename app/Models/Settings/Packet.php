<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packet extends Model
{
    protected $fillable = ['id','code','name','largs','hieghs','longs','currency_code','price','status','created_at'];
    use HasFactory;
}
