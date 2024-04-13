<?php

namespace App\Http\Middleware;

use App\Events\ApiRequestEvent;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

class ApiRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response =  $next($request);

        $data = [
            'user_id' => auth()->id(),
            'service' => $request->route()->getName(),
            'request_url' => $request->fullUrl(),
            'request_body' => $request->getContent(),
            'response_code' => $response->status(),
            'response_body' => $response->getContent(),
            'ip_address' => $request->ip(),
        ];

        event(new ApiRequestEvent($data));

        return $response;
    }
}
