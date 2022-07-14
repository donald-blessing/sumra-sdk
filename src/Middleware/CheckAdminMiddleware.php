<?php

namespace Sumra\SDK\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $adminUsers = explode(',', env('SUMRA_ADMIN_USERS', ''));

        if (empty($adminUsers) || Auth::user() == nill || 
        !in_array(Auth::user()->getAuthIdentifier(), $adminUsers)) {
            return response()->jsonApi([
                'type' => 'danger',
                'title' => 'Access error',
                'message' => "You have not permissions to access"
            ], 403);
        }

        return $next($request);
    }
}
