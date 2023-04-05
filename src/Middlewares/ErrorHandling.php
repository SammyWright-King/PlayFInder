<?php

namespace Playfinder\Middlewares;

use Psr\Http\Message\RequestInterface as Request;
//use Slim\Http\Response as Response;

class ErrorHandling
{
    public function __invoke( $request,  $response, $exception)
    {
        $uri = $request->getUri();
        $path = $uri->getPath();
        $payload = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ];

        return $response->withJson(
            $payload,
            $exception->getCode(),
            JSON_PRETTY_PRINT
        );


    }
}