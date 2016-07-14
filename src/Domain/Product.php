<?php

namespace RipeAndReady\Domain;

/**
 * Class Product
 * @package RipeAndReady\Domain
 * Contains a scraped product
 */
class Product implements \JsonSerializable
{

    private $title;
    private $description;
    private $unitPrice;
    private $size;

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size)
    {
        $this->size = $size;
    }

    /**
     * @param float $unitPrice
     */
    public function setUnitPrice(float $unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return float
     */
    public function getUnitPrice():float
    {
        return $this->unitPrice;
    }

    /**
     * @return array
     * Defines a structure for serializing this domain
     */
    public function jsonSerialize():array
    {
        return array(
            'title'         => $this->title,
            'size'          => $this->size,
            'unit_price'    => number_format($this->unitPrice, 2),
            'description'   => $this->description
        );
    }
}
