<?php

declare(strict_types=1);

namespace App\Security;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class AdminVoter implements VoterInterface
{
    public function vote(ServerRequestInterface $request)
    {
        $uri = $request->getUri()->getPath();
        $ip = $request->getServerParams()['REMOTE_ADDR'];

        if ($ip !== '127.0.0.s1' && $uri === '/admin') {
            return VoterInterface::ACCESS_DENIED;
        }


        return VoterInterface::ACCESS_ABSTAIN;
    }
}
