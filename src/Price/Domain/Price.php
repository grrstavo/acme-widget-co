<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Price\Domain;

/**
 * Value object representing a monetary price.
 * Prices are stored internally as integers (cents) to avoid floating-point precision issues.
 */
final class Price
{
    /**
     * @param int $amount
     * @throws \InvalidArgumentException
     */
    public function __construct(
        private readonly int $amount
    ) {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Price cannot be negative');
        }
    }

    /**
     * Creates a new Price from a float value.
     *
     * The float value is converted to cents internally.
     *
     * @param float $amount
     * @throws \InvalidArgumentException
     * @return self
     */
    public static function fromFloat(float $amount): self
    {
        return new self((int) round($amount * 100));
    }

    /**
     * Converts the internal cents value to a float in dollars.
     *
     * @return float
     */
    public function toFloat(): float
    {
        return $this->amount / 100;
    }

    /**
     * Adds another Price to this one.
     *
     * @param self $other
     * @return self
     */
    public function add(self $other): self
    {
        return new self($this->amount + $other->amount);
    }

    /**
     * Subtracts another Price from this one.
     *
     * @param self $other
     * @return self
     */
    public function subtract(self $other): self
    {
        return new self($this->amount - $other->amount);
    }

    /**
     * Multiplies this Price by a quantity.
     *
     * @param int $quantity
     * @return self
     */
    public function multiply(int $quantity): self
    {
        return new self($this->amount * $quantity);
    }

    /**
     * Compares this Price with another for equality.
     *
     * @param self $other
     * @return bool
     */
    public function equals(self $other): bool
    {
        return $this->amount === $other->amount;
    }
} 