<?php

namespace RipeAndReady\Service;

use RipeAndReady\Domain\Dom;
use RipeAndReady\Constant\DomFilter;

/**
 * Class ProductsService
 * @package RipeAndReady\Service
 * Provides functionality for interacting with a set of products
 */
class ProductsService
{
    /** @var Dom */
    private $page;

    /**
     * ProductsService constructor.
     * @param Dom $page
     */
    public function __construct(Dom $page)
    {
        $this->page = $page;
    }
    
    /**
     * Extracts the list of links to individual product pages from the list page
     * @return array
     */
    public function getProductUrls(): array
    {
        $filteredCrawler = $this->page->getContent()->filter(DomFilter::PRODUCT_LINK);

        $results = array();

        if (0 < $filteredCrawler->count()) {
            foreach ($filteredCrawler as $i => $node) {
                $results[$i] = $node->getAttribute('href');
            }
        }

        return $results;
    }
}