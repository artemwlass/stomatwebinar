<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CaptureAttribution
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $keys = [
            'utm_source',
            'utm_medium',
            'utm_campaign',
            'utm_content',
            'utm_term',
            'gclid',
            'fbclid',
            'yclid',
        ];

        $incoming = array_filter(
            $request->only($keys),
            fn ($value) => filled($value)
        );

        if (!empty($incoming)) {
            $attribution = array_merge(session('attribution', []), $incoming);
            $attribution['landing_url'] = $request->fullUrl();
            $attribution['landing_path'] = $request->path();
            $attribution['referrer'] = $request->headers->get('referer');
            $attribution['captured_at'] = now()->toDateTimeString();

            session(['attribution' => $attribution]);
            Cookie::queue('attribution_data', json_encode($attribution, JSON_UNESCAPED_UNICODE), 60 * 24 * 90);
        } elseif (!session()->has('attribution')) {
            $fromCookie = $request->cookie('attribution_data');
            $decoded = is_string($fromCookie) ? json_decode($fromCookie, true) : null;

            if (is_array($decoded) && !empty($decoded)) {
                session(['attribution' => $decoded]);
            }
        }

        return $next($request);
    }
}

