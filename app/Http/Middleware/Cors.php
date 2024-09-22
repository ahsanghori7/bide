<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set("Access-Control-Allow-Headers", '*');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Vary', 'Authorization, Accept-Encoding');
        $compressedContent = gzencode($response->getContent(), 9);
        $response->header('Content-Encoding', 'gzip');
        $response->setContent($compressedContent);
        return $response;
    }
}
