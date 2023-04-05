<?php


namespace Playfinder\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Playfinder\Repositories\ForecastRepository;
use Playfinder\Repositories\SearchRepository;

class BaseController
{
    protected $forecast_repository;
    protected $search_repository;

    public function __construct(ForecastRepository $forecast_repository, SearchRepository $search_repository)
    {


        $this->forecast_repository = $forecast_repository;
        $this->search_repository = $search_repository;
    }


    /**
     * @param Response $response
     * @param array $data
     * @return Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * main forecast method
     */
    public function forecast(Response $response, array $data = [])
    {

            //first check if location is a valid entry
            $location = $this->search_repository->checkLocation($data['q']);

            if(empty($location)){

                $response->getBody()->write(json_encode(["error" => "location can not be resolved"]));
            }
            else{
                //call the forecast method on the forecast repository
                $ans = $this->forecast_repository->forecast($data);

                if(array_key_exists('body', $ans)){

                    $forecast = $this->forecast_repository->weatherForecast($ans['body']);
                    $response->getBody()->write(json_encode($forecast));
                }else{

                    $error = $ans['error'];
                    $response->getBody()->write("$error");
                }
                $response->getStatusCode($ans['code']);
            }
            return $response->withHeader('Content-Type', 'application/json');
    }
}