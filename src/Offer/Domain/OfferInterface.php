<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Offer\Domain;

use AcmeWidgetCo\Product\Domain\ProductCatalog;
use AcmeWidgetCo\Price\Domain\Price;

/**
 * Interface for special offers that can be applied to a basket.
 * Offers are callable objects that calculate discounts based on the basket contents.
 */
interface OfferInterface
{
    /**
     * Calculates the discount amount for the items in the basket.
     *
     * @param array<string, int> $items
     * @param ProductCatalog $catalog
     * @return Price
     */
    public function __invoke(array $items, ProductCatalog $catalog): Price;
} 