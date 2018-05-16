<?php

use Nyholm\Psr7\Factory\ServerRequestFactory;
use Nyholm\Psr7\Response;

require __DIR__.'/vendor/autoload.php';

$request = (new ServerRequestFactory())->createServerRequestFromGlobals();

$query = $request->getQueryParams();
if (isset($query['page']) && $query['page'] === 'foo') {
    $response = new Response(200, [], 'Foo page');
} else {
    $response = new Response(200, [], 'Welcome to index!');
}

// Send response
echo $response->getBody();
