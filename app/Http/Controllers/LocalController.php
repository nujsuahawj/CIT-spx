<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalController extends Controller
{
    public function index($local)
    {
        session(['local' => $local]);
        return redirect()->back();
    }
}
