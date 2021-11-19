<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cod extends Model
{
    use HasFactory;

    protected $fillable = ['code','name','percent'];
    
}
