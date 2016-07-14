<?php

namespace RipeAndReadyTests\Unit\Service;

use Symfony\Component\DomCrawler\Crawler;
use RipeAndReadyTests\Unit\BaseUnit;
use RipeAndReady\Service\ProductService;
use RipeAndReady\Domain\Product;
use RipeAndReady\Domain\Dom;

class ProductServiceTest extends BaseUnit
{
    /** @var ProductService */
    protected $object;

    public function setup()
    {
        $dom = new Dom();
        $dom->setContent(new Crawler(file_get_contents(__DIR__ . '../../../data/response/product-page.txt')));
        $dom->setSize(39186);
        $this->object = new ProductService($dom);
    }
    
    public function testGetProduct()
    {
        /** @var Product $result */
        $result = $this->object->getProduct();

        $this->assertInstanceOf('RipeAndReady\Domain\Product', $result);
        $this->assertSame('Sainsbury\'s Apricot Ripe & Ready x5', $this->getProtectedProperty($result, 'title'));
        $this->assertSame(3.50, $result->getUnitPrice());
        $this->assertSame('Apricots', $this->getProtectedProperty($result, 'description'));
        $this->assertSame('39.19kb', $this->getProtectedProperty($result, 'size'));
    }

    public function testGetProductTitle()
    {
        $result = $this->invokeProtectedMethod($this->object, 'getProductTitle');
        $this->assertSame('Sainsbury\'s Apricot Ripe & Ready x5', $result);
    }

    public function testGetUnitPrice()
    {
        $result = $this->invokeProtectedMethod($this->object, 'getUnitPrice');
        $this->assertSame(3.50, $result);
    }

    public function testGetDescription()
    {
        $result = $this->invokeProtectedMethod($this->object, 'getDescription');
        $this->assertSame('Apricots', $result);
    }

    public function testGetSize()
    {
        $result = $this->invokeProtectedMethod($this->object, 'getSize');
        $this->assertSame('39.19kb', $result);
    }

    public function testExtractUnitPrice()
    {
        $result = $this->invokeProtectedMethod($this->object, 'extractUnitPrice', array('£5.99/unit'));
        $this->assertSame(5.99, $result);
    }


}