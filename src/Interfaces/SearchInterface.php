<?php

namespace Playfinder\Interfaces;

interface SearchInterface
{
    /**
     * @param $location
     * @return mixed
     * check if location is a valid entry
     */
    public function checkLocation($location);
}