<?php

use Nyholm\Psr7\Factory\ServerRequestFactory;
use Nyholm\Psr7\Response;

require __DIR__.'/../vendor/autoload.php';

$request = (new ServerRequestFactory())->createServerRequestFromGlobals();
$response = new Response();

$middlewares[] = new \App\Middleware\Router();

$runner = (new \Relay\RelayBuilder())->newInstance($middlewares);
$response = $runner($request, $response);

// Send response
echo $response->getBody();
