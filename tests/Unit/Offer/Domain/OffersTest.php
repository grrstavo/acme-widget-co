<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Offer\Domain;

use AcmeWidgetCo\Offer\Domain\CompositeOffer;
use AcmeWidgetCo\Offer\Domain\RedWidgetOffer;
use AcmeWidgetCo\Price\Domain\Price;
use AcmeWidgetCo\Product\Domain\Product;
use AcmeWidgetCo\Product\Domain\ProductCatalog;
use PHPUnit\Framework\TestCase;

final class OffersTest extends TestCase
{
    private ProductCatalog $catalog;

    protected function setUp(): void
    {
        $this->catalog = new ProductCatalog();
        $this->catalog->add(Product::create('R01', 'Red Widget', 3295));
        $this->catalog->add(Product::create('G01', 'Green Widget', 2495));
    }

    public function testRedWidgetOffer(): void
    {
        $offer = new RedWidgetOffer();

        // No red widgets
        $this->assertEquals(0, $offer([], $this->catalog)->toFloat());

        // One red widget
        $this->assertEquals(0, $offer(['R01' => 1], $this->catalog)->toFloat());

        // Two red widgets
        $this->assertEquals(1647.5, $offer(['R01' => 2], $this->catalog)->toFloat());

        // Three red widgets
        $this->assertEquals(1647.5, $offer(['R01' => 3], $this->catalog)->toFloat());

        // Four red widgets
        $this->assertEquals(3295, $offer(['R01' => 4], $this->catalog)->toFloat());

        // Five red widgets
        $this->assertEquals(3295, $offer(['R01' => 5], $this->catalog)->toFloat());

        // Six red widgets
        $this->assertEquals(4942.5, $offer(['R01' => 6], $this->catalog)->toFloat());
    }

    public function testRedWidgetOfferWithOtherProducts(): void
    {
        $offer = new RedWidgetOffer();

        // Two red widgets and one green
        $this->assertEquals(1647.5, $offer(['R01' => 2, 'G01' => 1], $this->catalog)->toFloat());

        // Two red widgets and two greens
        $this->assertEquals(1647.5, $offer(['R01' => 2, 'G01' => 2], $this->catalog)->toFloat());
    }

    public function testCompositeOffer(): void
    {
        $offer = new CompositeOffer([
            new RedWidgetOffer()
        ]);

        // Two red widgets
        $this->assertEquals(1647.5, $offer(['R01' => 2], $this->catalog)->toFloat());

        // Two red widgets and one green
        $this->assertEquals(1647.5, $offer(['R01' => 2, 'G01' => 1], $this->catalog)->toFloat());
    }

    public function testEmptyCompositeOffer(): void
    {
        $offer = new CompositeOffer([]);
        $this->assertEquals(0, $offer(['R01' => 2], $this->catalog)->toFloat());
    }
}
