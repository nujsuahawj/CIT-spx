<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['image','title_la','title_en','slug','short_des_la','short_des_en','des_la','des_en','postcate_id',
        'is_new','view','published','user_id','branch_id'];
    
    public function postcategoryname()
    {
        return $this->belongsTo('App\Models\Web\PostCategory','postcate_id','id');
    }
    public function username()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function branchname()
    {
        return $this->belongsTo('App\Models\Branch','branch_id','id');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Models\Web\Tag');
    }

}
