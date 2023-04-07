<?php

namespace Playfinder\Repositories;

use GuzzleHttp\Psr7\Request;
use Psr\Container\ContainerInterface;
use Playfinder\Interfaces\ForecastInterface;
use function PHPUnit\Framework\throwException;

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
    public function forecast($fields = [])
    {
        try{
            $fields['key'] = $this->ci->get('api_key');

            $request = new Request('GET', 'forecast.json');
            $response = $this->client->send($request, [
                'query' => $fields
            ]);

            $forecasts = (array) json_decode($response->getBody()->getContents(), true);

            return [
                "status" => true,
                "code" => $response->getStatusCode(),
                "body" => $forecasts['forecast']['forecastday']
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
    public function weatherForecast($forecasts)
    {
        $arr = [];

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
                    "forecast" => $forecast['day']['condition']['text'],
                ]);
            }
        }

        return $arr;
    }

    /**
     * @param array $data
     * @return mixed
     *
     */
    public function getWeatherDisplay(array $data)
    {
        try{
            $condition = $data[0]['day']['condition'];
            $icon = $condition['icon'];
            $icon_url = substr($icon, 2);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $icon_url);
            $data = curl_exec($ch);
            curl_close($ch);

            return $data;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}