<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Product\Domain;

use AcmeWidgetCo\Price\Domain\Price;

/**
 * Entity representing a product in the catalog.
 * Products are immutable and identified by their code.
 */
final class Product
{
    /**
     * @param ProductCode $code
     * @param string $name
     * @param Price $price
     */
    private function __construct(
        private readonly ProductCode $code,
        private readonly string $name,
        private readonly Price $price
    ) {
    }

    /**
     * Creates a new Product.
     *
     * @param string $code
     * @param string $name
     * @param float $price
     * @return self
     */
    public static function create(string $code, string $name, float $price): self
    {
        return new self(
            new ProductCode($code),
            $name,
            Price::fromFloat($price)
        );
    }

    /**
     * Returns the product code.
     *
     * @return ProductCode
     */
    public function getCode(): ProductCode
    {
        return $this->code;
    }

    /**
     * Returns the product name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the product price.
     *
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }
}
