<?php

namespace App\Middleware;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Security implements MiddlewareInterface
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $uri = $request->getUri()->getPath();
        $ip = $request->getServerParams()['REMOTE_ADDR'];

        if ($ip !== '127.0.0.1' && $uri === '/admin') {
            return new Response(403, [], 'Forbidden');
        }

        if ($uri === '/images/4711/delete') {
            if (true /* user is not "bob" */) {
                return new Response(403, [], 'Forbidden');
            }
        }

        return $next($request, $response);
    }
}
