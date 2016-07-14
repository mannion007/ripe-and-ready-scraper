<?php

namespace RipeAndReady\Domain;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Dom
 * @package RipeAndReady\Domain
 * Contains the DOM and file size of a scraped page (in bytes)
 */
class Dom
{

    /** @var  Crawler */
    private $content;
    private $size;

    /**
     * @return mixed
     */
    public function getContent():Crawler
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getSize():string
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size)
    {
        $this->size = $size;
    }
}
