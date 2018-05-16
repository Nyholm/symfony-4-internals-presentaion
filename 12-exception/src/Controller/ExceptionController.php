<?php

declare(strict_types=1);

namespace App\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\RequestInterface;

class ExceptionController
{
    public function run(RequestInterface $request)
    {
        throw new \RuntimeException('This is an exception');
    }
}