<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\Slider;
use App\Http\Resources\SliderResource;

class SliderApiController extends Controller
{
    public function index()
    {
        return SliderResource::collection(Slider::orderBy('id','desc')->where('status', 1)->get());
    }
}
