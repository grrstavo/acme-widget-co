<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Product\Domain;

use AcmeWidgetCo\Price\Domain\Price;
use AcmeWidgetCo\Product\Domain\Product;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    public function testCreate(): void
    {
        $product = Product::create('R01', 'Red Widget', 3295);

        $this->assertEquals('R01', $product->getCode()->getCode());
        $this->assertEquals('Red Widget', $product->getName());
        $this->assertEquals(329500, $product->getPrice()->toInt());
    }

    public function testZeroPrice(): void
    {
        $product = Product::create('R01', 'Red Widget', 0);
        $this->assertEquals(0, $product->getPrice()->toInt());
    }

    public function testNegativePrice(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Product::create('R01', 'Red Widget', -1000);
    }
}
