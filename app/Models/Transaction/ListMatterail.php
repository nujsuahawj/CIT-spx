<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListMatterail extends Model
{
    use HasFactory;
    protected $fillable = ['id','rvcode','mcode'];
}
