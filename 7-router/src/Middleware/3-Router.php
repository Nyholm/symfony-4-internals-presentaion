<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Router implements MiddlewareInterface
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $uri = $request->getUri()->getPath();

        $routes = array(
            '/foo' =>  'App\\Controller\\FooController::FooAction',
            '/images/upload' => 'App\\Controller\\ImageController::uploadAction',
            '/admin/account' => 'App\\Controller\\ManagerController::accountAction',
            '/admin/password' => 'App\\Controller\\ManagerController::passwordAction',
            // More static routes
            '/' => 'App\\Controller\\StartpageController::startpageAction',
        );

        if (isset($routes[$uri])) {
            $response = call_user_func($routes[$uri], $request);

            return $next($request, $response);
        }

        $regex =
            '{^(?'
                .'|/images/([^/]++)/(?'
                    .'|show(*:31)'
                    .'|delete(*:44)'
                    // my dynamic and complex regex
                .')'
            .')$}sD';


        if (preg_match($regex, $uri, $matches)) {
            $routes = array(
                31 => array('App\\Controller\\ImageController::showAction', array('id')),
                44 => array('App\\Controller\\ImageController::deleteAction', array('id')),
            );

            list($controller, $vars) = $routes[(int) $matches['MARK']];

            $parameters = [$request];
            // Find variables
            foreach ($vars as $i => $v) {
                if (isset($matches[1 + $i])) {
                    $parameters[$v] = $matches[1 + $i];
                }
            }

            $response = call_user_func_array($controller, $parameters);

            return $next($request, $response);
        }

        $response = $response->withStatus(404);
        $response->getBody()->write('Not Found');

        return $next($request, $response);
    }
}
