<?php

namespace Playfinder\Interfaces;

interface ForecastInterface
{
    /**
     * @return mixed
     *
     * forecast method
     */
    public function forecast($fields);

    /**
     * @param $weather
     * @return mixed
     * return weather forecast summary
     */
    public function weatherForecast($weather);

    /**
     * @param array $data
     * @return mixed
     *
     * get weather display
     */
    public function getWeatherDisplay(array $data);
}