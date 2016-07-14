<?php

namespace RipeAndReady\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RipeAndReady\Constant\Url;
use RipeAndReady\Service\DomService;
use RipeAndReady\Service\ProductsService;
use RipeAndReady\Service\ProductService;
use RipeAndReady\Domain\Products;

/**
 * Class ProductScrapeCommand
 * @package RipeAndReady\Console\Command
 * The main class responsible for running the application
 */
class ProductScrapeCommand extends Command
{
    /** @var  DomService */
    private $domService;
    
    public function __construct(DomService $domService)
    {
        parent::__construct();
        $this->domService = $domService;
    }

    protected function configure()
    {
        $this
            ->setName('ripeandready:scrape')
            ->setDescription('Scrape product information from Sainsbury\'s Ripe and Ready');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $listPageBody = $this->domService->getBody(Url::PRODUCTS);

        $productsService = new ProductsService($listPageBody);

        $productLinks = $productsService->getProductUrls();

        $products = new Products();

        foreach ($productLinks as $productLink) {
            $productPageBody = $this->domService->getBody($productLink);
            $productsService = new ProductService($productPageBody);
            $products->addProduct($productsService->getProduct());
        }

        $json = json_encode($products, JSON_PRETTY_PRINT);
        $output->writeln($json);
    }
}