<?php

namespace Playfinder\Controller;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Stream;


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
     * ordinary forecast for location or show image
     */
    public function ordinaryForecast(Request $request, Response $response, $location)
    {
        $query_data = ["q" => $location];

        if(!$this->isLocationValid($location)){
            $response->getBody()->write(json_encode(["error" => "Unknown location"]));
            return $response->withHeader('Content-Type', 'application/json');

        }else{
            //check if request has header accept and image
            if($accept_type = $request->getHeader('accept')){
                if(str_contains($accept_type[0], "image")){

                    $file = $this->showImage($query_data);

                    $response->getBody()->write($file);
                    return $response->withHeader('Content-Type', 'image/*');
                }
                die("only image header is allowed");
            }else{
                $forecast = $this->forecast($query_data);
                $response->getBody()->write(json_encode($forecast));

                return $response->withHeader('Content-Type', 'application/json');
            }
        }
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