<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Visit;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ipAddress = $request->ip();
        $sessionKey = 'visited_site_' . $ipAddress;

        if (!session()->has($sessionKey)) {
            Visit::create([
                'ip_address' => $ipAddress,
                'visited_at' => Carbon::now(),
            ]);

            session()->put($sessionKey, true);
        }

        return $next($request);
    }
}
