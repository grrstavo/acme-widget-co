<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Basket\Domain;

use AcmeWidgetCo\Product\Domain\ProductCatalog;
use AcmeWidgetCo\Delivery\Domain\DeliveryRuleInterface;
use AcmeWidgetCo\Offer\Domain\OfferInterface;
use AcmeWidgetCo\Price\Domain\Price;

/**
 * Shopping basket that calculates totals including delivery costs and special offers.
 * The basket maintains a collection of products and their quantities.
 */
final class Basket
{
    /**
     * @var array<string, int>
     */
    private array $items = [];

    /**
     * @param ProductCatalog $catalog
     * @param DeliveryRuleInterface $deliveryRule
     * @param OfferInterface $offer
     */
    public function __construct(
        private readonly ProductCatalog $catalog,
        private readonly DeliveryRuleInterface $deliveryRule,
        private readonly OfferInterface $offer
    ) {
    }

    /**
     * Adds a product to the basket.
     * 
     * @param string $productCode
     * @throws \InvalidArgumentException
     * @return void
     */
    public function add(string $productCode): void
    {
        $this->items[$productCode] = ($this->items[$productCode] ?? 0) + 1;
    }

    /**
     * Returns the items in the basket.
     *
     * @return array<string, int>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Calculates the discount for the basket.
     *
     * @return Price
     */
    public function calculateDiscount(): Price
    {
        return ($this->offer)($this->items, $this->catalog);
    }

    /**
     * Calculates the delivery cost for the basket.
     *
     * @param Price $subtotal
     * @return Price
     */
    public function calculateDelivery(Price $subtotal): Price
    {
        return ($this->deliveryRule)($subtotal);
    }

    /**
     * Calculates the total cost of the basket including delivery costs and special offers.
     *
     * @return float
     */
    public function total(): float
    {
        $subtotal = $this->calculateSubtotal();
        $discount = $this->calculateDiscount();

        $subtotal = $subtotal->subtract($discount);

        $delivery = $this->calculateDelivery($subtotal);

        return $subtotal->toFloat() + $delivery->toFloat();
    }

    /**
     * Calculates the subtotal of all products in the basket.
     *
     * @return Price
     */
    public function calculateSubtotal(): Price
    {
        $total = Price::fromFloat(0.0);

        foreach ($this->items as $code => $quantity) {
            if (!$product = $this->catalog->findByCode($code)) {
                continue;
            }

            $total = $total->add($product->getPrice()->multiply($quantity));
        }

        return $total;
    }
} 