<?php

namespace RipeAndReadyTests\Unit\Domain;

use RipeAndReadyTests\Unit\BaseUnit;
use RipeAndReady\Domain\Products;
use RipeAndReady\Domain\Product;

class ProductsTest extends BaseUnit
{

    public function testAddProduct()
    {
        $products = new Products();
        $expectedTotal = 0.00;

        for($i=0; $i <100; $i++) {

            $product = new Product();
            $product->setTitle('My Lovely Product ' . $i);
            $product->setDescription('Product ' . $i . ' description');
            $product->setUnitPrice($i);
            $product->setSize(5000 + $i);

            $expectedTotal += $i;

            $products->addProduct($product);

            $this->assertInternalType('array', $this->getProtectedProperty($products, 'results'));
            $this->assertCount(($i + 1), $this->getProtectedProperty($products, 'results'));
            $this->assertSame($product, $this->getProtectedProperty($products, 'results')[$i]);
            $this->assertSame($expectedTotal, $this->getProtectedProperty($products, 'total'));
        }
    }

    public function testGetUnitPriceTotal()
    {
        $products = new Products();
        $expectedTotal = 0.00;

        for($i=0; $i <100; $i++) {
            $product = new Product();
            $product->setUnitPrice($i);
            $products->addProduct($product);
            $expectedTotal += $i;
        }

        $this->assertSame($expectedTotal, $this->invokeProtectedMethod($products, 'getUnitPriceTotal'));
    }

    public function testJsonSerialize()
    {
        $products = new Products();

        for($i=0; $i <3; $i++) {

            $product = new Product();
            $product->setTitle('My Lovely Product ' . $i);
            $product->setDescription('Product ' . $i . ' description');
            $product->setUnitPrice($i);
            $product->setSize(5000 + $i . 'kb');
            $products->addProduct($product);
        }

        $result = json_encode($products);

        $expectedResult = file_get_contents(__DIR__ . '../../../data/json/products.json');
        $this->assertSame($expectedResult, $result);
    }
}