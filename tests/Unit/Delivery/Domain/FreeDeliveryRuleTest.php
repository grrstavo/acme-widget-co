<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Delivery\Domain;

use AcmeWidgetCo\Delivery\Domain\FreeDeliveryRule;
use AcmeWidgetCo\Price\Domain\Price;
use PHPUnit\Framework\TestCase;

final class FreeDeliveryRuleTest extends TestCase
{
    private FreeDeliveryRule $rule;

    protected function setUp(): void
    {
        $this->rule = new FreeDeliveryRule();
    }

    public function testCalculateDeliveryCostForLargeBasket(): void
    {
        $this->assertEquals(0, ($this->rule)(new Price(9000))->toFloat());
    }
}
