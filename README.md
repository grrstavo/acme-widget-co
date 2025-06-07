# Acme Widget Co

A simple e-commerce basket system that calculates totals including delivery costs and special offers.

## Features

- Product catalog with Red, Green, and Blue Widgets
- Delivery cost calculation based on order value
- Special offers (e.g., Buy one get one half price on Red Widgets)
- Type-safe value objects for prices and product codes
- Dependency injection for clean architecture
- Unit and integration tests with PHPUnit
- Static analysis with PHPStan

## Technical Stack

- PHP 8.3
- Composer for dependency management
- Docker & Docker Compose for development
- PHPUnit for testing
- PHPStan for static analysis

## Project Structure

```
src/
├── Basket/
│   └── Domain/
│       └── Basket.php
├── Delivery/
│   └── Domain/
│       ├── CompositeDeliveryRule.php
│       ├── DeliveryRule.php
│       ├── FreeDeliveryRule.php
│       ├── MediumDeliveryRule.php
│       └── StandardDeliveryRule.php
├── Offer/
│   └── Domain/
│       ├── CompositeOffer.php
│       ├── Offer.php
│       └── RedWidgetOffer.php
├── Price/
│   └── Domain/
│       └── Price.php
└── Product/
    └── Domain/
        ├── Product.php
        ├── ProductCatalog.php
        └── ProductCode.php
```

## Design Patterns

- **Strategy Pattern**: For interchangeable delivery rules and offers
- **Composite Pattern**: For combining multiple rules and offers
- **Value Objects**: For prices and product codes
- **Dependency Injection**: For clean architecture

## Assumptions

1. **Pricing**:
   - Prices stored in pence (integers)
   - Display in dollars with 2 decimal places
   - Example: $32.95 stored as 3295

2. **Delivery Rules**:
   - Standard: $4.95 (orders under $50)
   - Medium: $2.95 ($50-$90)
   - Free: $0 (over $90)

3. **Special Offers**:
   - Red Widget: Buy one get one half price
   - Applied before delivery costs

## Usage

```php
$basket = new Basket($catalog, $deliveryRules, $offers);
$basket->add('R01'); // Red Widget
$basket->add('G01'); // Green Widget
$total = $basket->total();
```

## Development

```bash
# Install dependencies
composer install

# Start development environment
docker-compose up -d

# Run tests
composer test

# Run with coverage
composer test-coverage
```
