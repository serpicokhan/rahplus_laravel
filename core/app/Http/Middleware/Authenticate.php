<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('api/*')) {
                $notify[] = 'Unauthorized request';
                return apiResponse('unauthenticated', 'error', $notify, statusCode: 401);
            }
            return route('user.login');
        }
    }
}
