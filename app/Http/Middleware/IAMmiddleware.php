<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class IAMmiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Session()->has('user_role')){
            if(Session::get('user_role') == '0'){
                //bach fach middleware dyal IsAdmin mali  yrej3o mamymchich l profile yrja3 fin kan
                if(Session()->has('newUser')){
                    if(Session::get('newUser') == 1){
                        return redirect()->back();
                    }
                }
                //bach fach middleware dyal IsAdmin mali  yrej3o mamymchich l profile yrja3 fin kan
                return redirect('/profile')->with('adminAccess','Access restricted for admins only !');
        }
        }
        return $next($request);
    }
}
