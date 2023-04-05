<?php

namespace PlayfinderTest\Controller;

use Playfinder\Controller\Ping;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class PingTest extends TestCase
{
    private Ping $controller;

    protected function setUp(): void
    {
        $this->controller = new Ping();
    }

    public function testPongs()
    {
        $request = $this->createMock(RequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $stream = $this->createMock(StreamInterface::class);

        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $stream->expects($this->once())
            ->method('write')
            ->with("pong");

        $this->controller->pong($request, $response);
    }
}
