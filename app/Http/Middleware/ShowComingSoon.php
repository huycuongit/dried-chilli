<?php

namespace App\Http\Middleware;

use App\Support\AdminJwt;
use Closure;
use Illuminate\Http\Request;

class ShowComingSoon
{
    /**
     * Paths that must keep working while the public site is hidden.
     */
    protected $except = [
        'admin',
        'admin/*',
        'ckfinder/*',
        'contract/*',
        'paypal/webhook',
    ];

    public function handle(Request $request, Closure $next)
    {
        if (!config('app.coming_soon') || $request->is($this->except)) {
            return $next($request);
        }

        // Logged-in admins can still preview the real site.
        if (app(AdminJwt::class)->authenticate($request)) {
            return $next($request);
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Coming soon.'], 503);
        }

        return response()->view('frontend.coming-soon');
    }
}
