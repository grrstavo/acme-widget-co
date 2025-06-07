<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery\Domain;

use AcmeWidgetCo\Price\Domain\Price;

/**
 * Composite delivery rule that combines multiple delivery rules.
 * The first non-zero delivery cost is returned.
 */
final class CompositeDeliveryRule implements DeliveryRuleInterface
{
    /**
     * @param array<DeliveryRuleInterface> $rules
     */
    public function __construct(
        private readonly array $rules = []
    ) {
    }

    /**
     * Calculates the delivery cost by applying each rule in sequence.
     * Returns the first non-zero delivery cost found.
     *
     * @param Price $subtotal
     * @return Price
     */
    public function __invoke(Price $subtotal): Price
    {
        foreach ($this->rules as $rule) {
            $cost = ($rule)($subtotal);

            if ($cost->toFloat() > 0) {
                return $cost;
            }
        }

        return new Price(0);
    }
} 