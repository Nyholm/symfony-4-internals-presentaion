<?php

use Nyholm\Psr7\Factory\ServerRequestFactory;
use Nyholm\Psr7\Response;

require __DIR__.'/../vendor/autoload.php';

$request = (new ServerRequestFactory())->createServerRequestFromGlobals();

$kernel = new \App\Kernel('dev', true);
$response = $kernel->handle($request);

// Send response
echo $response->getBody();
