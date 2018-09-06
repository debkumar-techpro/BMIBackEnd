<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $headers = [
            'Content-Type' => 'application/json;charset=UTF-8',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'HEAD,GET,POST,PUT,PATCH,DELETE,OPTIONS',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400',
            /*'Access-Control-Allow-Headers' => $request->header('Access-Control-Request-Headers')*/
            'Access-Control-Allow-Headers' => 'Content-Type, Content-Length, Accept-Encoding, Authorization, Cookie'
        ];
        return  response()->json($request->isMethod('OPTIONS'));
        exit();
        if ($request->isMethod('OPTIONS')) {
            return response(null, 200, $headers);
        }
        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }
        return $response;
    }

/*    if($_SERVER['HTTP_ORIGIN'] == 'https://bm.aptive.guru'||$_SERVER['HTTP_ORIGIN'] == 'http://stagingbm.aptive.guru'||$_SERVER['HTTP_ORIGIN'] == 'http://localhost:4200'){
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, Authorization, Cookie");
header('Access-Control-Max-Age: 86400'); // cache for 1 day
}*/
}