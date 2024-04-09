<?php

namespace App\Http\Middleware;

use Closure;

class SetLanguage
{
    public function handle($request, Closure $next)
    {
        if ($request->hasCookie('lang')) {
            $lang = $request->cookie('lang');
            app()->setLocale($lang);
        } else {
            app()->setLocale('es');
        }

        return $next($request);
    }
}