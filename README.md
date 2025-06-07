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

## Installation

### Prerequisites

- Docker and Docker Compose
- Git
- PHP 8.3 (for local development)

### Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/grrstavo/acme-widget-co.git
   cd acme-widget-co
   ```

2. Start the development environment:
   ```bash
   docker-compose up -d
   ```

3. Install dependencies:
   ```bash
   docker-compose exec app composer install
   ```

4. Verify the installation:
   - Access the application at `http://localhost:8080`
   - Run the test suite: `docker-compose exec app composer test`

## Testing

### Unit Tests

Run the unit test suite:
```bash
# Using Docker
docker-compose exec app composer test

# Local development
composer test
```

The unit tests cover:
- Individual components in isolation
- Value objects (Price, ProductCode)
- Delivery rules
- Special offers
- Basket calculations

### Static Analysis

Run PHPStan for static analysis:
```bash
# Using Docker
docker-compose exec app composer phpstan

# Local development
composer phpstan
```

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

The application runs on port 8080 and demonstrates the following use cases:

1. Basket 1: B01, G01
2. Basket 2: R01, R01
3. Basket 3: R01, G01
4. Basket 4: B01, B01, R01, R01, R01

Access the application at `http://localhost:8080` to see the results.

```php
$basket = new Basket($catalog, $deliveryRules, $offers);
$basket->add('R01'); // Red Widget
$basket->add('G01'); // Green Widget
$total = $basket->total();
```

## Development

### Docker Commands

```bash
# Start the development environment
docker-compose up -d

# Stop the development environment
docker-compose down

# Rebuild containers
docker-compose build

# Run tests
docker-compose exec app composer test

# Run static analysis
docker-compose exec app composer phpstan

# Access container shell
docker-compose exec app bash
```

### Local Development

```bash
# Install dependencies
composer install

# Run tests
composer test
```
