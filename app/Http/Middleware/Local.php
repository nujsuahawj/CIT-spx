<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Local
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //return $next($request);
        //\App::setLocale(session('local'));
        if(\Session::has('local')){
            \App::setlocale(\Session::get('local'));
        }
        return $next($request);
    }
}
