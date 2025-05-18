<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeveloperToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $reqDevToken = $request->header('dev-token') ?? null;
        $devToken    = developerToken();

        if ($devToken != $reqDevToken) {
            $notify[] = 'Unauthorized request';
            return apiResponse("unauthorized_request", "error", $notify);
        }
        return $next($request);
    }
}
