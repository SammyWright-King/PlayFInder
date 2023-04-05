<?php

namespace Playfinder\Repositories;

use GuzzleHttp\Psr7\Request;
use Playfinder\Interfaces\SearchInterface;
use Psr\Container\ContainerInterface;

class SearchRepository implements SearchInterface
{
    private $ci;
    private $client;

    public function __construct(ContainerInterface  $container)
    {
        $this->ci = $container;
        $this->client = $this->ci->get('client');
    }

    /**
     * @param $location
     * @return array|mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * check if location is a valid entry
     */
    public function checkLocation($location)
    {
        try{
            $fields = [
                "key" => $this->ci->get("api_key"),
                "q" => $location
            ];

            $request = new Request('GET', 'search.json');
            $response = $this->client->send($request, [
                'query' => $fields
            ]);

            return (array) json_decode($response->getBody()->getContents(), true);

        }catch(Exception $e){
            return [
                "status" => false,
                "code" => 500,
                "error" => "internal server error"
            ];
        }
    }
}