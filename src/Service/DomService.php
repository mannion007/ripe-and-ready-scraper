<?php

namespace RipeAndReady\Service;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use RipeAndReady\Constant\HttpRequestMethod;
use RipeAndReady\Domain\Dom;

/**
 * Class DomService
 * @package RipeAndReady\Service
 * Provides functionality for obtaining and interacting with the DOM of a scraped page
 */
class DomService
{

    /** @var Client */
    private $guzzle;

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * @param string $url
     * @return Dom
     * Provides a crawler object for the body of the requested URL
     */
    public function getBody(string $url): Dom
    {
        $resource = $this->guzzle->request(HttpRequestMethod::GET_REQUEST, $url);

        $crawler = new Crawler($resource->getBody()->getContents());

        $dom = new Dom();
        $dom->setContent($crawler);
        $dom->setSize($resource->getBody()->getSize());

        return $dom;
    }
}