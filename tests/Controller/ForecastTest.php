<?php

namespace PlayfinderTest\Controller;

use Playfinder\Controller\Task;
use PHPUnit\Framework\TestCase;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ForecastTest extends TestCase
{
    public Task $task;

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


    public function testForecast()
    {
        $forecast = $this->task->forecast([
            "q" => "swansea",
            "days" => 1
        ]);

        $this->assertNotEmpty($forecast);
        $this->assertIsArray($forecast);
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * test the islocationvalid method
     */
    public function testIsLocationValid()
    {
        $reply = $this->task->isLocationValid("Swansea");

        $this->assertIsBool($reply);
    }

    public function testShowImage()
    {
        $stream = $this->task->showImage(["q" => "swansea"]);

        $this->assertIsString($stream);
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * test for ordinary forecast
     */
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