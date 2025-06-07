<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Basket\Domain;

use AcmeWidgetCo\Basket\Domain\Basket;
use AcmeWidgetCo\Delivery\Domain\CompositeDeliveryRule;
use AcmeWidgetCo\Delivery\Domain\FreeDeliveryRule;
use AcmeWidgetCo\Delivery\Domain\MediumDeliveryRule;
use AcmeWidgetCo\Delivery\Domain\StandardDeliveryRule;
use AcmeWidgetCo\Offer\Domain\CompositeOffer;
use AcmeWidgetCo\Offer\Domain\RedWidgetOffer;
use AcmeWidgetCo\Product\Domain\Product;
use AcmeWidgetCo\Product\Domain\ProductCatalog;
use PHPUnit\Framework\TestCase;

final class BasketTest extends TestCase
{
    private ProductCatalog $catalog;
    private Basket $basket;

    protected function setUp(): void
    {
        $this->catalog = new ProductCatalog();
        $this->catalog->add(Product::create('R01', 'Red Widget', 3295));
        $this->catalog->add(Product::create('G01', 'Green Widget', 2495));
        $this->catalog->add(Product::create('B01', 'Blue Widget', 795));

        $compositeDeliveryRule = new CompositeDeliveryRule([
            new FreeDeliveryRule(),
            new MediumDeliveryRule(),
            new StandardDeliveryRule()
        ]);

        $compositeOffer = new CompositeOffer([
            new RedWidgetOffer()
        ]);

        $this->basket = new Basket($this->catalog, $compositeDeliveryRule, $compositeOffer);
    }

    public function testAddAndCalculateSubtotal(): void
    {
        $this->basket->add('B01');
        $this->basket->add('G01');

        $this->assertEquals(3290, $this->basket->calculateSubtotal()->toFloat());
    }

    public function testAddSameProductMultipleTimes(): void
    {
        $this->basket->add('B01');
        $this->basket->add('B01');
        $this->basket->add('B01');

        $this->assertEquals(2385, $this->basket->calculateSubtotal()->toFloat());
    }

    public function testEmptyBasket(): void
    {
        $this->assertEquals(0, $this->basket->calculateSubtotal()->toFloat());
        $this->assertEquals(4.95, $this->basket->total());
    }

    public function testTotalWithStandardDelivery(): void
    {
        $this->basket->add('B01');
        $this->basket->add('G01');

        $this->assertEquals(3290, $this->basket->total());
    }

    public function testTotalWithMediumDelivery(): void
    {
        $this->basket->add('B01');
        $this->basket->add('G01');
        $this->basket->add('R01');

        $this->assertEquals(6585, $this->basket->total());
    }

    public function testTotalWithFreeDelivery(): void
    {
        $this->basket->add('R01');
        $this->basket->add('R01');
        $this->basket->add('R01');

        $this->assertEquals(8237.5, $this->basket->total());
    }

    public function testTotalWithOffers(): void
    {
        $this->basket->add('R01');
        $this->basket->add('R01');

        $this->assertEquals(4942.5, $this->basket->total());
    }
}
 