<?php

namespace Playfinder;

use DI\Bridge\Slim\Bridge;
use DI\Container;
use GuzzleHttp\Client;
use Playfinder\Controller\Ping;
use Playfinder\Controller\Task;
use Playfinder\Middlewares\ErrorHandling;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Slim\App;

class Router
{
    private App $app;
    private ContainerInterface $container;

    public function __construct()
    {
        $this->container = new Container();
        $this->configure();
        $this->app = Bridge::create($this->container);
    }

    private function configure()
    {
        //$this->container->set('api_key', 'API_KEY_HERE');
        $this->container->set('api_key', 'f20d578cb4f4454f8f3134419230304');
        $this->container->set('client', function(){
            return new Client([
                'base_uri' => 'http://api.weatherapi.com/v1/',
            ]);
        });

    }

    private function addRoutes()
    {
        $this->app->get('/ping', [Ping::class, 'pong']);

        $this->app->get('/{location}/forecast', [Task::class, 'ordinaryForecast']);
        $this->app->get('/{location}/{id: [1-9]+}-day', [Task::class, 'daysForecast']);

        $this->app->any('{route:.*}', function( $response) {
            $response->getBody()->write('page not found');
            return $response->withStatus(404);
        });
    }

    public function handle(RequestInterface $request)
    {
        $this->addRoutes();
        $this->app->addErrorMiddleware(true, true, true);
        $this->app->run($request);
    }
}
