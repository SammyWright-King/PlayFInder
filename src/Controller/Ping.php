<?php

namespace Playfinder\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Ping
{
    public function pong(RequestInterface $request, ResponseInterface $response): ResponseInterface {
        $response->getBody()->write('pong' . PHP_EOL);
        return $response;
    }
}
