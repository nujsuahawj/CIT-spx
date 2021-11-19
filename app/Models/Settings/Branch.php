<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = ['id','code','logo','company_photo','structure_photo','company_name_la','company_name_en','branch_type_id','dividend_id','tax_id','address_la','address_en','vill_id','dis_id','pro_id','phone','director',
    'whatsapp','facebook_fanpage','youtube','google_map','longitude','latitude','sign1','sign2','sign3','sign4','app_store','play_store','app_gallery','bill_header','bill_footer','active'];

    public function branchtypename()
    {
        return $this->belongsTo('App\Models\Settings\BranchType','branch_type_id','id');
    }
    public function dividendname()
    {
        return $this->belongsTo('App\Models\Settings\Dividend','dividend_id','id');
    }
    public function taxname()
    {
        return $this->belongsTo('App\Models\Settings\Tax','tax_id','id');
    }
    public function villname()
    {
        return $this->belongsTo('App\Models\Settings\Village','vill_id','id');
    }
    public function disname()
    {
        return $this->belongsTo('App\Models\Settings\District','dis_id','id');
    }
    public function proname()
    {
        return $this->belongsTo('App\Models\Settings\Province','pro_id','id');
    }
}
