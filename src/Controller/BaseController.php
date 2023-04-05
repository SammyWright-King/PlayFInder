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
     * should return array
     */
    public function forecast(array $data = []):array
    {
        //first check if location is a valid entry
        $location = $this->search_repository->checkLocation($data['q']);

        if(empty($location)){
            return ["error" => "location can not be resolved"];
        }
        else{
            //call the forecast method on the forecast repository
            $ans = $this->forecast_repository->forecast($data);

            if(array_key_exists('body', $ans)){

                return  $this->forecast_repository->weatherForecast($ans['body']);

            }else{

                return $ans['error'];
            }

        }
    }
}