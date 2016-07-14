<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use RipeAndReadyTests\Unit\BaseUnit;
use Symfony\Component\Console\Tester\CommandTester;
use RipeAndReady\Service\DomService;
use Symfony\Component\Console\Application;
use RipeAndReady\Console\Command\ProductScrapeCommand;
use \Symfony\Component\Console\Command\Command;

class ProductScrapeCommandTest extends BaseUnit
{
    public function testExecute()
    {
        $application = new Application();

        /** Define a series of mocked responses - the listing page (containing 7 links) then 7 product pages */
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'text/html'], file_get_contents(__DIR__ . '../../../data/response/products-page.txt')),
            new Response(200, ['Content-Type' => 'text/html'], file_get_contents(__DIR__ . '../../../data/response/product-page.txt')),
            new Response(200, ['Content-Type' => 'text/html'], file_get_contents(__DIR__ . '../../../data/response/product-page.txt')),
            new Response(200, ['Content-Type' => 'text/html'], file_get_contents(__DIR__ . '../../../data/response/product-page.txt')),
            new Response(200, ['Content-Type' => 'text/html'], file_get_contents(__DIR__ . '../../../data/response/product-page.txt')),
            new Response(200, ['Content-Type' => 'text/html'], file_get_contents(__DIR__ . '../../../data/response/product-page.txt')),
            new Response(200, ['Content-Type' => 'text/html'], file_get_contents(__DIR__ . '../../../data/response/product-page.txt')),
            new Response(200, ['Content-Type' => 'text/html'], file_get_contents(__DIR__ . '../../../data/response/product-page.txt'))
        ]);

        /** Define a Dom Service which will use a Guzzle client that returns the series of mocks */
        $domService = new DomService(new Client(['handler' => HandlerStack::create($mock)]));

        $application->add(new ProductScrapeCommand($domService));

        /** @var Command $command */
        $command = $application->find('ripeandready:scrape');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));

        $result = json_decode($commandTester->getDisplay());
        $this->assertCount(7, $result->results);
        $this->assertSame('24.50', $result->total);

    }
}