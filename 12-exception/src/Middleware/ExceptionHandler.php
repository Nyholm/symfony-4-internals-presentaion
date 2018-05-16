<?php

namespace App\Middleware;

use Cache\Adapter\Apcu\ApcuCachePool;
use Nyholm\Psr7\Response;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ExceptionHandler implements MiddlewareInterface
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        try {
            $response = $next($request, $response);
        } catch (\Throwable $exception) {
            $response = new Response(500, [], $exception->getMessage());
        }

        return $response;
    }
}
