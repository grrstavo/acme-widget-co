<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery\Domain;

use AcmeWidgetCo\Price\Domain\Price;

/**
 * Delivery rule that charges $2.95 for orders between $50 and $90.
 */
final class MediumDeliveryRule implements DeliveryRuleInterface
{
    private const MEDIUM_DELIVERY_MIN_THRESHOLD = 50.0;
    private const MEDIUM_DELIVERY_MAX_THRESHOLD = 90.0;
    private const MEDIUM_DELIVERY_COST = 2.95;

    /**
     * Calculates the delivery cost for a given order subtotal.
     * Returns $2.95 if the order total is between $50 and $90.
     *
     * @param Price $subtotal
     * @return Price
     */
    public function __invoke(Price $subtotal): Price
    {
        $amount = $subtotal->toFloat();

        if ($amount >= self::MEDIUM_DELIVERY_MIN_THRESHOLD && $amount < self::MEDIUM_DELIVERY_MAX_THRESHOLD) {
            return Price::fromFloat(self::MEDIUM_DELIVERY_COST);
        }

        return Price::fromFloat(0.0);
    }
} 