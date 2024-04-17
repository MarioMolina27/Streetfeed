<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,...$tipos): Response
    {
        $user = Auth::user();
        $userTypes = $user->typeUsers->pluck('name')->toArray();

        foreach ($tipos as $tipo) {
            if (in_array($tipo, $userTypes)) {
                return $next($request);
            }
        }

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
}
