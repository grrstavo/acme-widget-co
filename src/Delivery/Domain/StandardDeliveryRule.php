<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery\Domain;

use AcmeWidgetCo\Price\Domain\Price;

/**
 * Delivery rule that charges $4.95 for orders under $50.
 */
final class StandardDeliveryRule implements DeliveryRuleInterface
{
    private const STANDARD_DELIVERY_MAX_THRESHOLD = 50.0;
    private const STANDARD_DELIVERY_COST = 4.95;

    /**
     * Calculates the delivery cost for a given order subtotal.
     * Returns $4.95 if the order total is under $50.
     *
     * @param Price $subtotal
     * @return Price
     */
    public function __invoke(Price $subtotal): Price
    {
        if ($subtotal->toFloat() < self::STANDARD_DELIVERY_MAX_THRESHOLD) {
            return Price::fromFloat(self::STANDARD_DELIVERY_COST);
        }

        return Price::fromFloat(0.0);
    }
} 