<?php

namespace Playfinder\Interfaces;

interface ForecastInterface
{
    /**
     * @return mixed
     *
     * forecast method
     */
    public function forecast(array $fields = []);

    /**
     * @param $weather
     * @return mixed
     * return weather forecast summary
     */
    public function weatherForecast($weather);
}