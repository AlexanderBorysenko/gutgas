<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeoRedirectionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $url = $request->getRequestUri();

        if (
            preg_match('/^\/index.php/', $url)
            ||
            preg_match('/\/$/', $url)
        ) {
            $url = preg_replace('/^\/index.php/', '', $url);
            $url = preg_replace('/\/$/', '', $url);

            return redirect()->to(
                $url,
                301
            );
        }

        return $next($request);
    }
}
