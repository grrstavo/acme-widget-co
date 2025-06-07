<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Product\Domain;

/**
 * Collection of products that can be looked up by their code.
 * Provides a factory method to create a catalog with the default products.
 */
final class ProductCatalog
{
    /**
     * Creates a new product catalog with default products.
     *
     * @param array<Product> $products
     */
    public function __construct(
        private array $products = []
    ) {
    }

    /**
     * Adds a product to the catalog.
     *
     * @param Product $product
     * @return void
     */
    public function add(Product $product): void
    {
        $this->products[$product->getCode()->getCode()] = $product;
    }

    /**
     * Finds a product by its code.
     *
     * @param string $code
     * @return Product|null
     */
    public function findByCode(string $code): ?Product
    {
        return $this->products[$code] ?? null;
    }

    /**
     * Returns all products in the catalog.
     * @return array<string, Product>
     */
    public function getAll(): array
    {
        return $this->products;
    }
} 