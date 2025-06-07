<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Delivery\Domain;

use AcmeWidgetCo\Delivery\Domain\StandardDeliveryRule;
use AcmeWidgetCo\Price\Domain\Price;
use PHPUnit\Framework\TestCase;

final class StandardDeliveryRuleTest extends TestCase
{
    private StandardDeliveryRule $rule;

    protected function setUp(): void
    {
        $this->rule = new StandardDeliveryRule();
    }

    public function testCalculateDeliveryCostForEmptyBasket(): void
    {
        $this->assertEquals(4.95, ($this->rule)(new Price(0))->toFloat());
    }

    public function testCalculateDeliveryCostForSmallBasket(): void
    {
        $this->assertEquals(4.95, ($this->rule)(new Price(1000))->toFloat());
    }
}
