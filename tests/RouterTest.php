<?php

namespace PlayfinderTest;

use Playfinder\Router;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request;
use Slim\Psr7\Uri;

class RouterTest extends TestCase
{
    public function testBootstraps()
    {
        ob_start();
        $router = new Router();
        $router->handle(new Request(
            'GET',
            new Uri('http', 'localhost', 8080, '/ping'),
            new Headers(),
            [],
            [],
            (new StreamFactory)->createStream('')
        ));
        $this->assertEquals('pong', trim(ob_get_contents()));
        ob_end_clean();
    }



}
