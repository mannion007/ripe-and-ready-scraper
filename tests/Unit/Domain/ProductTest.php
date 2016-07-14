<?php

namespace RipeAndReadyTests\Unit\domain;

use RipeAndReadyTests\Unit\BaseUnit;
use RipeAndReady\Domain\Product;

class ProductTest extends BaseUnit
{

    public function testJsonSerialize()
    {
        $product = new Product();

        $product->setTitle('My Lovely Product');
        $product->setDescription('This product really is very nice');
        $product->setUnitPrice(4.99);
        $product->setSize('15.25kb');
        $result = json_encode($product);

        $expectedResult = file_get_contents(__DIR__ . '../../../data/json/product.json');
        $this->assertSame($expectedResult, $result);
    }

}