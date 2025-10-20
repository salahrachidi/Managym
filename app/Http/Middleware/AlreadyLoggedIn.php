<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlreadyLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Session()->has('user_id') && ( url('/home/login') == $request->url() || url('/home/register') ==
        $request->url() || url('/home') == $request->url()
        )){
            if(session()->get('logRole')=="1"){
                return redirect()->back();
            }else{
                return redirect('/profile');
            }
        }
        return $next($request);
    }
}
