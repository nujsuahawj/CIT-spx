<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\Service;
use App\Http\Resources\ServiceResource;

class ServiceApiController extends Controller
{
    public function index()
    {
        return ServiceResource::collection(Service::all());
    }
}
