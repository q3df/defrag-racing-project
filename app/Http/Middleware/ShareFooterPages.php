<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;


class ShareFooterPages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Inertia::share('footerPages', function () {
            return \App\Models\Page::where('footer_link', true)
                ->where('visible', true)
                ->get(['title', 'slug']);
        });
        return $next($request);
    }
}
