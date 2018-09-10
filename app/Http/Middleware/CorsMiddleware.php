<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $headers = [
            'Content-Type' => 'application/json;charset=UTF-8',
            'Access-Control-Allow-Origin' => 'http://192.168.1.103:4200',
            'Access-Control-Allow-Methods' => 'HEAD,GET,POST,PUT,PATCH,DELETE,OPTIONS',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400',
            'Access-Control-Allow-Headers' => $request->header('Access-Control-Request-Headers')
        ];
        if ($request->isMethod('OPTIONS')) {
            return response(null, 200, $headers);
        }
        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }
        return $response;
    }
}