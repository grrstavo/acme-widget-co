<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Product\Domain;

use AcmeWidgetCo\Price\Domain\Price;
use AcmeWidgetCo\Product\Domain\Product;
use AcmeWidgetCo\Product\Domain\ProductCatalog;
use PHPUnit\Framework\TestCase;

final class ProductCatalogTest extends TestCase
{
    private ProductCatalog $catalog;

    protected function setUp(): void
    {
        $this->catalog = new ProductCatalog();
        $this->catalog->add(Product::create('R01', 'Red Widget', 3295));
        $this->catalog->add(Product::create('G01', 'Green Widget', 2495));
    }

    public function testFindByCode(): void
    {
        $product = $this->catalog->findByCode('R01');
        $this->assertNotNull($product);
        $this->assertEquals('R01', $product->getCode()->getCode());
        $this->assertEquals('Red Widget', $product->getName());
        $this->assertEquals(329500, $product->getPrice()->toInt());
    }

    public function testFindByCodeNotFound(): void
    {
        $product = $this->catalog->findByCode('B01');
        $this->assertNull($product);
    }

    public function testGetAll(): void
    {
        $products = $this->catalog->getAll();
        $this->assertCount(2, $products);
        $this->assertArrayHasKey('R01', $products);
        $this->assertArrayHasKey('G01', $products);
    }

    public function testAddDuplicateProduct(): void
    {
        $this->catalog->add(Product::create('R01', 'Red Widget Updated', 3495));
        $product = $this->catalog->findByCode('R01');
        $this->assertNotNull($product);
        $this->assertEquals('Red Widget Updated', $product->getName());
        $this->assertEquals(349500, $product->getPrice()->toInt());
    }

    public function testEmptyCatalog(): void
    {
        $catalog = new ProductCatalog();
        $this->assertEmpty($catalog->getAll());
        $this->assertNull($catalog->findByCode('R01'));
    }

    public function testAddMultipleProducts(): void
    {
        $catalog = new ProductCatalog();
        $catalog->add(Product::create('R01', 'Red Widget', 329));
        $catalog->add(Product::create('G01', 'Green Widget', 249));
        $catalog->add(Product::create('B01', 'Blue Widget', 795));

        $products = $catalog->getAll();
        $this->assertCount(3, $products);
        $this->assertArrayHasKey('R01', $products);
        $this->assertArrayHasKey('G01', $products);
        $this->assertArrayHasKey('B01', $products);
    }
} 