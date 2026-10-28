<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceCanonicalUrl
{
    /**
     * Redirect requests to the scheme and host configured in APP_URL.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('local', 'testing') || in_array($request->getHost(), ['127.0.0.1', 'localhost', '::1'])) {
            return $next($request);
        }

        $canonicalUrl = rtrim((string) config('app.url'), '/');
        $parts = parse_url($canonicalUrl);

        if (!is_array($parts) || empty($parts['host'])) {
            return $next($request);
        }

        $scheme = strtolower($parts['scheme'] ?? $request->getScheme());
        $host = strtolower($parts['host']);
        $port = $parts['port'] ?? null;
        $defaultPort = $scheme === 'https' ? 443 : 80;
        $requestPort = $request->getPort();

        $hasCanonicalOrigin = strtolower($request->getScheme()) === $scheme
            && strtolower($request->getHost()) === $host
            && ($port ? $requestPort === (int) $port : $requestPort === $defaultPort);

        if ($hasCanonicalOrigin) {
            return $next($request);
        }

        $authority = $host;
        if ($port && (int) $port !== $defaultPort) {
            $authority .= ':' . $port;
        }

        $destination = $scheme . '://' . $authority . $request->getRequestUri();
        $status = $request->isMethod('GET') || $request->isMethod('HEAD') ? 301 : 308;

        return redirect()->away($destination, $status);
    }
}
