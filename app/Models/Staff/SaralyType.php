<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaralyType extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','salary'];
}
