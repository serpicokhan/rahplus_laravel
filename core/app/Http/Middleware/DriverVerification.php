<?php

namespace App\Http\Middleware;

use App\Constants\Status;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DriverVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $driver = auth()->user();

        // if (!$driver->dv) {
        //     $notify[] = 'Please complete your document verification for the next step.';
        //     return apiResponse("document_unverified", "error", $notify);
        // }
        // if (!$driver->vv) {
        //     $notify[] = 'Please complete your vehicle document verification for the next step.';
        //     return apiResponse("vehicle_unverified", "error", $notify);
        // }
        // if ($driver->dv == Status::PENDING) {
        //     $notify[] = 'Please complete your document verification for the next step.';
        //     return apiResponse("document_verification_pending", "error", $notify);
        // }
        // if ($driver->vv == Status::PENDING) {
        //     $notify[] = 'Please complete your vehicle document verification for the next step.';
        //     return apiResponse("vehicle_verification_pending", "error", $notify);
        // }

        return $next($request);
    }
}
