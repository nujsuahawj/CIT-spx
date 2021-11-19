<?php

namespace App\Models\Doc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocLocal extends Model
{
    use HasFactory;

    protected $fillable = ['date','type_id','title','storage_id','file','user_id','branch_id','note'];

    public function typename()
    {
        return $this->belongsTo('App\Models\Doc\DocType','type_id','id');
    }
    public function storagename()
    {
        return $this->belongsTo('App\Models\Doc\DocStorage','storage_id','id');
    }
    public function username()
    {
        return $this->belongsTo('App\Models\Doc\User','user_id','id');
    }

}
