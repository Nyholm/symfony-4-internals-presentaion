<?php

use Nyholm\Psr7\Factory\ServerRequestFactory;

require __DIR__.'/../vendor/autoload.php';

$request = (new ServerRequestFactory())->createServerRequestFromGlobals();

$query = $request->getQueryParams();
if (isset($query['page']) && $query['page'] === 'foo') {
    $response = (new \App\Controller\FooController())->run($request);
} else {
    $response = (new \App\Controller\StartpageController())->run($request);
}

// Send response
echo $response->getBody();
