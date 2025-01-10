<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    private const HEADER_NAME = 'Authorization';

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $apiAuthToken = $request->header(self::HEADER_NAME);

        if ($apiAuthToken !== Config::get('app.api_auth_token')) {
            return \Illuminate\Support\Facades\Response::json(status: 403);
        }

        return $next($request);
    }
}
