<?php
require __DIR__ . '/vendor/autoload.php';

use RipeAndReady\Console\Command\ProductScrapeCommand;
use Symfony\Component\Console\Application;
use GuzzleHttp\Client;
use RipeAndReady\Service\DomService;

$application = new Application();
$client = new DomService(new Client());
$application->add(new ProductScrapeCommand($client));
$application->run();