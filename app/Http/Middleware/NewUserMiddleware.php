<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class NewUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if( Session()->has('newUser') ){
            if(Session::get('newUser') == 1){
                return redirect()->back()->with('pauMsg','You must pay before access to your personnel account !');
            }else{
                return redirect('/profile');
            }
        }
        return $next($request);
    }
}
