<?php

namespace Playfinder\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class ErrorHandling
{

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $existingContent = (string) $response->getBody();

        if($response->getStatusCode() == 500)
        {
            $response = new Response();
            $response->getBody()->write("Internal Server Error");
        }else{
            $response = new Response();
            $response->getBody()->write('BEFORE' . $existingContent);
        }

        return $response;
    }
}

