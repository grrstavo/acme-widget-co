<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery\Domain;

use AcmeWidgetCo\Price\Domain\Price;

/**
 * Delivery rule that provides free delivery for orders over $90.
 */
final class FreeDeliveryRule implements DeliveryRuleInterface
{
    private const FREE_DELIVERY_MIN_THRESHOLD = 90.0;
    private const FREE_DELIVERY_COST = 0.0;

    /**
     * Calculates the delivery cost for a given order subtotal.
     * Returns free delivery (0.0) if the order total is $90 or more.
     *
     * @param Price $subtotal
     * @return Price
     */
    public function __invoke(Price $subtotal): Price
    {
        if ($subtotal->toFloat() >= self::FREE_DELIVERY_MIN_THRESHOLD) {
            return Price::fromFloat(self::FREE_DELIVERY_COST);
        }

        return Price::fromFloat(0.0);
    }
} 