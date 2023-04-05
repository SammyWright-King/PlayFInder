<?php

namespace Playfinder\Controller;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Task extends BaseController
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $location
     * @return Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @GET forecast for the current location
     */
    public function ordinaryForecast(Request $request, Response $response, $location)
    {
        $query_data = ["q" => $location];

        $forecast = $this->forecast($query_data);
        $response->getBody()->write(json_encode($forecast));

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $location
     * @param $id
     * @return Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * forecast for days
     */
    public function daysForecast(Response $response, $location, $id)
    {
        $query_data = array (
            "q" => $location,
            "days" => $id
        );

        $forecast = $this->forecast($query_data);

        $response->getBody()->write(json_encode($forecast));

        return $response->withHeader('Content-Type', 'application/json');
    }
}