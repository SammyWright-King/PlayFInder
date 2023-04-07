<?php

namespace App\Handler;


use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpException;
use Slim\Psr7\Response;
use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

class ErrorRendering implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails):string
    {

        if ($exception instanceof HttpNotFoundException) {
            $message = 'This page could not be found.';
        }else{
            $message = 'Internal Server problem.';
        }

        return $message;

    }
}