<?php

namespace RipeAndReadyTests\Unit\Service;

use RipeAndReady\Service\DomService;
use RipeAndReadyTests\Unit\BaseUnit;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class DomServiceTest extends BaseUnit
{
    public function testGetBody()
    {
        $response = file_get_contents(__DIR__ . '../../../data/response/product-page.txt');

        /** Add a single mocked response to the queue, then create a DOM service which will return it */
        $mock = new MockHandler([new Response(200, ['Content-Type' => 'text/html'], $response)]);
        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $domService = new DomService($client);

        $result = $domService->getBody('/');
        $this->assertInstanceOf('RipeAndReady\Domain\Dom', $result);
        $this->assertSame('39186', $result->getSize());
    }
}
