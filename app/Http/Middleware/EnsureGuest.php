<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureGuest
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
        if (Auth::check()) {
            $user = Auth::user();
            $userTypes = $user->typeUsers->pluck('name')->toArray();
            if($userTypes[0]==='Admin'){
                return redirect()->route('admin');
            }
            else if($userTypes[0]==='Rider'){
                return redirect()->route('delivery');
            }
            else if($userTypes[0]==='Provider'){
                return redirect()->route('managedelivery');
            }
            else{
                return redirect()->route('landing');
            }
        }

        return $next($request);
    }
}