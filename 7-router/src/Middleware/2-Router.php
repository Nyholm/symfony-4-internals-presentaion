<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Router implements MiddlewareInterface
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $uri = $request->getUri()->getPath();

        if (0 === strpos($uri, '/admin')) {
            if (0 === strpos($uri, '/admin/account')) {
                $response = (new \App\Controller\ManagerController())->accountAction($request);
            }
            if (0 === strpos($uri, '/admin/password')) {
                $response = (new \App\Controller\ManagerController())->passwordAction($request);
            }
        } elseif (0 === strpos($uri, '/images')) {
            if (0 === strpos($uri, '/images/upload')) {
                $response = (new \App\Controller\ImageController())->uploadAction($request);
            }
            if (preg_match('#^/images/(?P<id>[^/]++)/show#sD', $uri, $matches)) {
                $response = (new \App\Controller\ImageController())->showAction($request, $matches['id']);
            }
            if (preg_match('#^/images/(?P<id>[^/]++)/delete#sD', $uri, $matches)) {
                $response = (new \App\Controller\ImageController())->deleteAction($request, $matches['id']);
            }
        } elseif ($uri === '/') {
            $response = (new \App\Controller\StartpageController())->run($request);
        } elseif ($uri === '/foo') {
            $response = (new \App\Controller\FooController())->run($request);
        } else {
            $response = $response->withStatus(404);
            $response->getBody()->write('Not Found');
        }

        return $next($request, $response);
    }
}
