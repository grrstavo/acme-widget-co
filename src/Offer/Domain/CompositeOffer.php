<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Offer\Domain;

use AcmeWidgetCo\Product\Domain\ProductCatalog;
use AcmeWidgetCo\Price\Domain\Price;

/**
 * Composite offer that combines multiple offers.
 * The total discount is the sum of all individual offer discounts.
 */
final class CompositeOffer implements OfferInterface
{
    /**
     * @param array<OfferInterface> $offers
     */
    public function __construct(
        private readonly array $offers = []
    ) {
    }

    /**
     * Calculates the total discount by applying each offer in sequence.
     *
     * @param array<string, int> $items
     * @param ProductCatalog $catalog
     * @return Price
     */
    public function __invoke(array $items, ProductCatalog $catalog): Price
    {
        $totalDiscount = new Price(0);

        foreach ($this->offers as $offer) {
            $totalDiscount = $totalDiscount->add(($offer)($items, $catalog));
        }

        return $totalDiscount;
    }
} 