<?php

namespace App\Models\Doc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocExternal extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
}
