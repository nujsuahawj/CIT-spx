<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = ['image','parent_id','name_la','name_en','name_cn','status'];

    public function subcatalog(){
        return $this->hasMany('App\Models\Web\BlogCategory','parent_id');
    }
}
