<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\Page;
use App\Models\Settings\Branch;

class AboutApiController extends Controller
{
    public function getAbout()
    {
        return response ([
            'data'=> Page::select('title_la','title_en','short_des_la','short_des_en','des_la','des_en')->where('id',1)->get()
        ],200);
    }

    public function getTerms()
    {
        return response ([
            'data'=> Page::select('title_la','title_en','short_des_la','short_des_en','des_la','des_en')->where('id',2)->get()
        ],200);
    }
    public function getBranch()
    {
        return response ([
            'data'=> Branch::all()
        ],200);
    }

    public function getBranchByProid($id)
    {
        return response ([
            'data'=> Branch::all()->where('pro_id',$id)
        ],200);
    }
}
