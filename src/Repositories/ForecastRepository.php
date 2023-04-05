<?php

namespace Playfinder\Repositories;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use Psr\Container\ContainerInterface;
use Playfinder\Interfaces\ForecastInterface;

class ForecastRepository implements ForecastInterface
{
    private $ci;
    private $client;
    public function __construct(ContainerInterface  $container)
    {
        $this->ci = $container;
        $this->client = $this->ci->get('client');
    }

    /**
     * @param array $fields
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * forecast weather
     */
    public function forecast(array $fields = [])
    {
        try{

            $fields['key'] = $this->ci->get('api_key');

            $request = new Request('GET', 'forecast.json');
            $response = $this->client->send($request, [
                'query' => $fields
            ]);

            //return $response->getBody()->getContents();
            return [
                "status" => true,
                "code" => $response->getStatusCode(),
                "body" => (array) json_decode($response->getBody()->getContents(), true)
            ];
        }catch(Exception $e){
            return [
                "status" => false,
                "code" => 500,
                "error" => "internal server error"
            ];
        }

    }

    /**
     * @param $weather_detail
     * @return array|mixed
     * extract and format the weather forecast
     */
    public function weatherForecast($weather_detail)
    {

        $arr = [];

        //$result = json_decode($weather_detail, TRUE);

        $forecasts = $weather_detail['forecast']['forecastday'];

        if(count($forecasts) == 1){
            $forecast = $forecasts[0];
            $arr['date'] = $forecast['date'];
            $arr['forecast'] = $forecast['day']['condition']['text'];
        }
        else{
            foreach($forecasts as $forecast)
            {
                //extract the day's weather condition
                array_push($arr, [
                    "date" => $forecast['date'],
                    "forecast" => $forecast['day']['condition']['text']
                ]);
            }
        }

        return $arr;
    }
}