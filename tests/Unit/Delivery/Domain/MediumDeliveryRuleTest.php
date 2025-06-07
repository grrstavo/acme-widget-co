<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Delivery\Domain;

use AcmeWidgetCo\Delivery\Domain\MediumDeliveryRule;
use AcmeWidgetCo\Price\Domain\Price;
use PHPUnit\Framework\TestCase;

final class MediumDeliveryRuleTest extends TestCase
{
    private MediumDeliveryRule $rule;

    protected function setUp(): void
    {
        $this->rule = new MediumDeliveryRule();
    }

    public function testCalculateDeliveryCostForMediumBasket(): void
    {
        $this->assertEquals(2.95, ($this->rule)(new Price(5000))->toFloat());
    }

    public function testCalculateDeliveryCostForLargeBasket(): void
    {
        $this->assertNotEquals(2.95, ($this->rule)(new Price(9000))->toFloat());
    }
}
