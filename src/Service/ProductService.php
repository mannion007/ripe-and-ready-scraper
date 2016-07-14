<?php

namespace RipeAndReady\Service;

use RipeAndReady\Domain\Dom;
use RipeAndReady\Domain\Product;
use RipeAndReady\Constant\DomFilter;

/**
 * Class ProductService
 * @package RipeAndReady\Service
 * Provides functionality for interacting with an individual product
 */
class ProductService
{
    private $page;

    /**
     * ProductService constructor.
     * @param Dom $page
     */
    public function __construct(Dom $page)
    {
        $this->page = $page;
    }

    /**
     * @return Product
     * Builds a Product Domain from the Dom of the page
     */
    public function getProduct(): Product
    {
        $product = new Product();
        $product->setTitle($this->getProductTitle());
        $product->setSize($this->getSize());
        $product->setUnitPrice($this->getUnitPrice());
        $product->setDescription($this->getDescription());

        return $product;
    }

    /**
     * @return string
     * Extracts the product title from the DOM
     */
    private function getProductTitle(): string
    {
        $filteredDom = $this->page->getContent()->filter(DomFilter::PRODUCT_TITLE);
        return $filteredDom->first()->text();
    }

    /**
     * @return mixed
     * Extracts the unit price from the DOM
     */
    private function getUnitPrice(): float
    {
        $filteredDom = $this->page->getContent()->filter(DomFilter::PRODUCT_PRICE);
        return $this->extractUnitPrice($filteredDom->first()->text());
    }

    /**
     * @return string
     * Extracts the description from the page
     */
    private function getDescription(): string
    {
        $filteredDom = $this->page->getContent()->filter(DomFilter::PRODUCT_DESCRIPTION);
        return $filteredDom->first()->text();
    }

    /**
     * @return string
     * Determines the size of the page (no assets). As page is not multibyte (1 char = 1 byte), can rely on strlen
     */
    private function getSize(): string
    {
        return number_format($this->page->getSize()/1000, 2) . 'kb';
    }

    /**
     * @param string $rawUnitPrice
     * @return mixed
     * Extracts the actual unit price from the raw string from the page
     */
    private function extractUnitPrice(string $rawUnitPrice):float
    {
        preg_match('/[0-9]+.[0-9]+/', $rawUnitPrice, $extractedPrice);
        return current($extractedPrice);
    }
}