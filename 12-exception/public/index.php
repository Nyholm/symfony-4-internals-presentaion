<?php

use Nyholm\Psr7\Factory\ServerRequestFactory;
use Nyholm\Psr7\Response;

require __DIR__.'/../vendor/autoload.php';

$request = (new ServerRequestFactory())->createServerRequestFromGlobals();

$kernel = new \App\Kernel('dev', true);
$response = $kernel->handle($request);

// Send response
emitHeaders($response);
emitStatusLine($response);
echo $response->getBody();



























function emitStatusLine(\Psr\Http\Message\ResponseInterface $response)
{
    $reasonPhrase = $response->getReasonPhrase();
    $statusCode   = $response->getStatusCode();

    header(sprintf('HTTP/%s %d%s', $response->getProtocolVersion(), $statusCode, ($reasonPhrase ? ' ' . $reasonPhrase : '')), true, $statusCode);
}

function emitHeaders(\Psr\Http\Message\ResponseInterface $response)
{
    $statusCode = $response->getStatusCode();

    foreach ($response->getHeaders() as $header => $values) {
        $name  = filterHeader($header);
        $first = $name === 'Set-Cookie' ? false : true;
        foreach ($values as $value) {
            header(sprintf('%s: %s', $name, $value), $first, $statusCode);
            $first = false;
        }
    }
}

function filterHeader($header)
{
    $filtered = str_replace('-', ' ', $header);
    $filtered = ucwords($filtered);
    return str_replace(' ', '-', $filtered);
}