<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        app()->setLocale(config('app.locale'));

        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }

        Inertia::share('locale', app()->getLocale());
        Inertia::share('locales', config('app.locales'));
        // translations from lang/{currentLanguage}/app
        Inertia::share('translations', trans('app'));

        return $next($request);
    }
}
