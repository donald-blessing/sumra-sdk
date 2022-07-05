<?php

namespace Sumra\SDK\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sumra\SDK\Enums\MicroservicesEnums;

class CheckMSMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!MicroservicesEnums::checkMicroservice($request->header('app-id', null))) {
            return response()->jsonApi([
                'type' => 'danger',
                'title' => 'Access error',
                'message' => "You have not permissions to access this service",
            ], 403);
        }

        return $next($request);
    }
}
