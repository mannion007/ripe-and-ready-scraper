<?php

namespace RipeAndReady\Domain;

/**
 * Class Products
 * @package RipeAndReady\Domain
 * Contains a list of scraped products
 */
class Products implements \JsonSerializable
{
    /** @var  Product[] */
    private $results;
    private $total = 0;

    /**
     * @param Product $product
     * Adds a product domain to this list
     */
    public function addProduct(Product $product)
    {
        $this->results[] = $product;
        $this->total += $product->getUnitPrice();
    }

    /**
     * @return float
     * Adds up the total price of all the units
     */
    public function getUnitPriceTotal():float
    {
        $total = 0;
        foreach($this->results as $result) {
            $total += $result->getUnitPrice();
        }
        return $total;
    }

    /**
     * @return array
     * Defines a structure for serializing this domain
     */
    public function jsonSerialize():array
    {
        return array(
            'results'   => $this->results,
            'total'     => number_format($this->getUnitPriceTotal(), 2)
        );
    }
}