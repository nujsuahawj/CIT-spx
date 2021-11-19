<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['image','title_la','title_en','slug','short_des_la','short_des_en','des_la','des_en','user_id','status'];
    
    public function username()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
