<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $tokenName = null): Response
    {

        $tokenNameFormRequest = $request->user()->currentAccessToken()->name;

        if ($tokenName != $tokenNameFormRequest) {
            $notify[] = 'Unauthorized request';
            return apiResponse('unauthenticated', 'error', $notify, statusCode: 401);
        }

        return $next($request);
    }
}
