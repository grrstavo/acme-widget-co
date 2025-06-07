<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Delivery\Domain;

use AcmeWidgetCo\Delivery\Domain\CompositeDeliveryRule;
use AcmeWidgetCo\Delivery\Domain\FreeDeliveryRule;
use AcmeWidgetCo\Delivery\Domain\MediumDeliveryRule;
use AcmeWidgetCo\Delivery\Domain\StandardDeliveryRule;
use AcmeWidgetCo\Price\Domain\Price;
use PHPUnit\Framework\TestCase;

final class CompositeDeliveryRuleTest extends TestCase
{
    private CompositeDeliveryRule $rule;

    protected function setUp(): void
    {
        $this->rule = new CompositeDeliveryRule([
            new FreeDeliveryRule(),
            new MediumDeliveryRule(),
            new StandardDeliveryRule()
        ]);
    }

    public function testCalculateDeliveryCostForEmptyBasket(): void
    {
        $this->assertEquals(4.95, ($this->rule)(new Price(0))->toFloat());
    }

    public function testCalculateDeliveryCostForSmallBasket(): void
    {
        $this->assertEquals(4.95, ($this->rule)(new Price(1000))->toFloat());
    }

    public function testCalculateDeliveryCostForMediumBasket(): void
    {
        $this->assertEquals(2.95, ($this->rule)(new Price(5000))->toFloat());
    }

    public function testCalculateDeliveryCostForLargeBasket(): void
    {
        $this->assertEquals(0, ($this->rule)(new Price(9000))->toFloat());
    }

    public function testCalculateDeliveryCostWithSingleRule(): void
    {
        $rule = new CompositeDeliveryRule([new StandardDeliveryRule()]);
        $this->assertEquals(4.95, ($rule)(new Price(1000))->toFloat());
    }
}
