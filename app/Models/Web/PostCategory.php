<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id','name_la','name_en'];

    public function subcatalog(){
        return $this->hasMany('App\Models\Web\PostCategory','parent_id');
    }
}
