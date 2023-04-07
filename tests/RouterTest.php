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

    /**
     * test weather forecast without image
     */
    public function testSingleForecast()
    {
        ob_start();
        $router = new Router();
        $router->handle(new Request(
            'GET',
            new Uri('http', 'localhost', 8080, '/london/forecast'),
            new Headers(),
            [],
            [],
            (new StreamFactory)->createStream('')
        ));

        $this->assertNotEmpty(ob_get_contents());
        $this->assertJson(ob_get_contents());
        ob_end_clean();
    }

    /**
     * test that with header image, output is a stream
     */
    public function testSingleForecastWithImage()
    {
        ob_start();
        $router = new Router();
        $router->handle(new Request(
            'GET',
            new Uri('http', 'localhost', 8080, '/london/forecast'),
            new Headers(['accept' => "image/*"]),
            [],
            [],
            (new StreamFactory)->createStream('')
        ));

        $this->assertNotEmpty(ob_get_contents());
        $this->assertIsString(ob_get_contents());
        ob_end_clean();
    }

    /**
     *
     * test forecast for days
     */
    public function testForecastFordays()
    {
        ob_start();
        $router = new Router();
        $router->handle(new Request(
            'GET',
            new Uri('http', 'localhost', 8080, '/london/1-day'),
            new Headers(),
            [],
            [],
            (new StreamFactory)->createStream('')
        ));

        $this->assertNotEmpty(ob_get_contents());
        $this->assertJson(ob_get_contents());

        $result = json_decode(ob_get_contents(), true);
        $this->assertGreaterThanOrEqual(1, $result);

        ob_end_clean();
    }


}
