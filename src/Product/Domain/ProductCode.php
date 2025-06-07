<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Product\Domain;

/**
 * Value object representing a product code.
 */
final class ProductCode
{
    /**
     * @param string $code
     */
    public function __construct(
        private readonly string $code
    ){
    }

    /**
     * Returns the product code.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Compares this ProductCode with another for equality.
     *
     * @param self $other
     * @return bool
     */
    public function equals(self $other): bool
    {
        return $this->code === $other->code;
    }
} 