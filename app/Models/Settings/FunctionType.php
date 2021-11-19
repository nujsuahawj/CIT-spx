<?php

namespace App\Models\settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunctionType extends Model
{
    protected $fillable = ['id','name','status'];
    use HasFactory;
}
