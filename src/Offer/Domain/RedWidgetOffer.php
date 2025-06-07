<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Offer\Domain;

use AcmeWidgetCo\Product\Domain\Product;
use AcmeWidgetCo\Product\Domain\ProductCatalog;
use AcmeWidgetCo\Price\Domain\Price;

/**
 * Special offer: Buy one red widget, get the second half price.
 * This offer applies to pairs of red widgets in the basket.
 */
final class RedWidgetOffer implements OfferInterface
{
    private const RED_WIDGET_CODE = 'R01';

    /**
     * Calculates the discount for the "buy one red widget, get the second half price" offer.
     * The discount is calculated for each pair of red widgets in the basket.
     *
     * @param array<string, int> $items
     * @param ProductCatalog $catalog
     * @return Price
     */
    public function __invoke(array $items, ProductCatalog $catalog): Price
    {
        $redWidgetQuantity = $items[self::RED_WIDGET_CODE] ?? 0;

        if ($redWidgetQuantity < 2) {
            return Price::fromFloat(0.0);
        }

        $redWidget = $catalog->findByCode(self::RED_WIDGET_CODE);

        if (!$redWidget) {
            return Price::fromFloat(0.0);
        }

        $pairs = (int) floor($redWidgetQuantity / 2);
        $discount = $redWidget->getPrice()->multiply($pairs)->toFloat() / 2;

        return Price::fromFloat($discount);
    }
} 