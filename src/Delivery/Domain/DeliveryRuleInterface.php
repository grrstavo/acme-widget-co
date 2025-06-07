<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery\Domain;

use AcmeWidgetCo\Price\Domain\Price;

/**
 * Interface for delivery cost calculation rules.
 * Implementations of this interface define how delivery costs are calculated based on the order total.
 */
interface DeliveryRuleInterface
{
    /**
     * Calculates the delivery cost for a given order subtotal.
     *
     * @param Price $subtotal
     * @return Price
     */
    public function __invoke(Price $subtotal): Price;
} 