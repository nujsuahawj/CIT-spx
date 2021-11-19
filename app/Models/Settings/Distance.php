<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{
    use HasFactory;
    protected $fillable = ['id','name','locate','branch_id','status'];
}
