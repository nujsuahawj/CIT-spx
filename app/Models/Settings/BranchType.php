<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchType extends Model
{
    use HasFactory;

    protected $fillable = ['name','deposit','note'];
}
