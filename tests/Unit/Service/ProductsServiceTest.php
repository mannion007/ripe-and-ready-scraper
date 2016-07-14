<?php

namespace RipeAndReadyTests\Unit\Service;

use Symfony\Component\DomCrawler\Crawler;
use RipeAndReadyTests\Unit\BaseUnit;
use RipeAndReady\Service\ProductsService;
use RipeAndReady\Domain\Dom;

class ProductsServiceTest extends BaseUnit
{

    /** @var ProductsService */
    protected $object;

    public function setup()
    {
        $dom = new Dom();
        $dom->setContent(new Crawler(file_get_contents(__DIR__ . '../../../data/response/products-page.txt')));
        $dom->setSize(39186);
        $this->object = new ProductsService($dom);
    }

    public function testGetProductUrls()
    {
        $result = $this->object->getProductUrls();

        $expectedResults = array(
            'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-apricot-ripe---ready-320g.html',
            'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocado-xl-pinkerton-loose-300g.html',
            'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocado--ripe---ready-x2.html',
            'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-avocados--ripe---ready-x4.html',
            'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-conference-pears--ripe---ready-x4-%28minimum%29.html',
            'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-golden-kiwi--taste-the-difference-x4-685641-p-44.html',
            'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/sainsburys-kiwi-fruit--ripe---ready-x4.html'
        );

        $this->assertInternalType('array', $result);
        $this->assertCount(7, $result);
        $this->assertSame($expectedResults, $result);
    }

}