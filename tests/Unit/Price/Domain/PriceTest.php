<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Price\Domain;

use AcmeWidgetCo\Price\Domain\Price;
use PHPUnit\Framework\TestCase;

final class PriceTest extends TestCase
{
    public function testCreateAndConvert(): void
    {
        $price = new Price(1000);
        $this->assertEquals(10.00, $price->toFloat());
        $this->assertEquals(1000, $price->toInt());
    }

    public function testAdd(): void
    {
        $price1 = new Price(1000);
        $price2 = new Price(2000);
        $result = $price1->add($price2);
        $this->assertEquals(3000, $result->toInt());
    }

    public function testMultiply(): void
    {
        $price = new Price(1000);
        $result = $price->multiply(2);
        $this->assertEquals(2000, $result->toInt());
    }

    public function testEquals(): void
    {
        $price1 = new Price(1000);
        $price2 = new Price(1000);
        $price3 = new Price(2000);

        $this->assertTrue($price1->equals($price2));
        $this->assertFalse($price1->equals($price3));
    }

    public function testZeroPrice(): void
    {
        $price = new Price(0);
        $this->assertEquals(0, $price->toInt());
        $this->assertEquals(0.00, $price->toFloat());
    }

    public function testNegativePrice(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $price = new Price(-1000);
    }

    public function testLargePrice(): void
    {
        $price = new Price(99999999);
        $this->assertEquals(99999999, $price->toInt());
        $this->assertEquals(999999.99, $price->toFloat());
    }

    public function testDecimalPrecision(): void
    {
        $price = new Price(1001);
        $this->assertEquals(10.01, $price->toFloat());
    }
} 