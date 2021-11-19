<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculateType extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','branch_id','status'];
}
