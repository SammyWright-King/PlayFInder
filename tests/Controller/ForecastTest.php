<?php

namespace PlayfinderTest\Controller;


use http\Encoding\Stream;
use Playfinder\Controller\Task;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ForecastTest extends TestCase
{
    private Task $task;

    protected function setup(): void
    {
        $forecast_repo = $this->getMockBuilder('\Playfinder\Repositories\ForecastRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $search_repo = $this->getMockBuilder('\Playfinder\Repositories\SearchRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->task = new Task($forecast_repo, $search_repo);
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * test the forecast method
     */
    public function testForecast()
    {
        $forecast = $this->task->forecast([
            "q" => "swansea",
            "days" => 2
        ]);

        $this->assertNotEmpty($forecast);
        $this->assertIsArray($forecast);
    }

    public function testOrdinaryForecast()
    {
        $request = $this->createMock(RequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $stream = $this->createMock(StreamInterface::class);

        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $stream->expects($this->once())
                ->method('write');

        $this->task->ordinaryForecast($request, $response, "london");

    }

}