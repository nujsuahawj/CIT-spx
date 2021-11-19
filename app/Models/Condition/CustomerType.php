<?php

namespace App\Models\Condition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    use HasFactory;

    protected $fillable = ['name','parent_id'];

    public function subcatalog(){
        return $this->hasMany('App\Models\Condition\CustomerType','parent_id');
    }
}
