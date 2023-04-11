<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogin
{

    public function handle(Request $request, Closure $next)
    {

        if( (auth()->user()->status != 'admin')  && (auth()->user()->status != 'writer') ){
            return redirect()->route('logout');
        }else{
            return $next($request);
        }
    }
}
