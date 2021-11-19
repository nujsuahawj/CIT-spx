<?php

namespace App\Models\Condition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VihicleType extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','status'];
}
