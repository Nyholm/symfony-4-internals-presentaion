<?php

use Nyholm\Psr7\Factory\ServerRequestFactory;
use Nyholm\Psr7\Response;

require __DIR__.'/../vendor/autoload.php';

$request = (new ServerRequestFactory())->createServerRequestFromGlobals();

$uri = $request->getUri()->getPath();
if ($uri === '/') {
    $response = (new \App\Controller\StartpageController())->run($request);
} elseif ($uri === '/foo') {
    $response = (new \App\Controller\FooController())->run($request);
} else {
    $response = new Response(404, [], 'Not found');
}

// Send response
echo $response->getBody();
