<?php
namespace Playfinder\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Playfinder\Repositories\ForecastRepository;
use Playfinder\Repositories\SearchRepository;

class BaseController
{
    public $forecast_repository;
    public $search_repository;

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

    public function forecast(array $data = [])
    {
        $ans = $this->forecast_repository->forecast($data);

        if($ans && array_key_exists('body', $ans) )
        {
            $forecast = $this->forecast_repository->weatherForecast($ans['body']);
            return $forecast;

        }else{
            return ["error" => "Error obtaining weather forecast."];
        }
    }

    /**
     * @param $data
     * @return array|mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     */
    public function showImage($data)
    {
        $ans = $this->forecast_repository->forecast($data);

        if($ans && array_key_exists('body', $ans) )
        {
            $forecast = $this->forecast_repository->getWeatherDisplay($ans['body']);
            return $forecast;

        }else{
            return "";
        }
    }

    /**
     * @param $data
     * @return bool
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * check location is valid
     */
    public function isLocationValid($location): bool
    {
        $location = $this->search_repository->checkLocation($location);

        if(empty($location)){
            return false;
        }else{
            return true;
        }
    }

}