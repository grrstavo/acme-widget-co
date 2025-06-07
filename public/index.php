<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AcmeWidgetCo\Basket\Domain\Basket;
use AcmeWidgetCo\Delivery\Domain\FreeDeliveryRule;
use AcmeWidgetCo\Delivery\Domain\MediumDeliveryRule;
use AcmeWidgetCo\Delivery\Domain\StandardDeliveryRule;
use AcmeWidgetCo\Delivery\Domain\CompositeDeliveryRule;
use AcmeWidgetCo\Offer\Domain\CompositeOffer;
use AcmeWidgetCo\Product\Domain\Product;
use AcmeWidgetCo\Product\Domain\ProductCatalog;;
use AcmeWidgetCo\Offer\Domain\RedWidgetOffer;

// Initialize product catalog with default products
$catalog = new ProductCatalog();
$catalog->add(Product::create('R01', 'Red Widget', 32.95));
$catalog->add(Product::create('G01', 'Green Widget', 24.95));
$catalog->add(Product::create('B01', 'Blue Widget', 7.95));

// Initialize delivery rules
$deliveryRules = new CompositeDeliveryRule([
    new FreeDeliveryRule(),
    new MediumDeliveryRule(),
    new StandardDeliveryRule()
]);

// Initialize offers
$offers = new CompositeOffer([
    new RedWidgetOffer()
]);

// Function to print basket contents and total
function printBasket(Basket $basket, ProductCatalog $catalog): void
{
    echo "Basket Items:<br>";

    foreach ($basket->getItems() as $code => $quantity) {
        $product = $catalog->findByCode($code);

        echo sprintf(
            "- %s: %d x $%.2f = $%.2f<br>",
            $product->getName(),
            $quantity,
            $product->getPrice()->toFloat(),
            $product->getPrice()->multiply($quantity)->toFloat()
        );
    }

    $subtotal = $basket->calculateSubtotal();
    $discount = $basket->calculateDiscount();
    $subtotal = $subtotal->subtract($discount);
    $delivery = $basket->calculateDelivery($subtotal);

    echo sprintf("<br>Discount: -$%.2f", $basket->calculateDiscount()->toFloat());
    echo sprintf("<br>Subtotal: $%.2f", $subtotal->toFloat());
    echo sprintf("<br>Delivery: $%.2f", $delivery->toFloat());
    echo sprintf("<br>Total: $%.2f<br><br>", $basket->total());
}

// Test Case 1: Multiple products, standard delivery
echo "Test Case 1: Multiple products, standard delivery<br>";
$basket1 = new Basket($catalog, $deliveryRules, $offers);
$basket1->add('B01');
$basket1->add('G01');
printBasket($basket1, $catalog);

// Test Case 2: Red widget offer
echo "Test Case 2: Red widget offer (buy one get second half price)<br>";
$basket2 = new Basket($catalog, $deliveryRules, $offers);
$basket2->add('R01');
$basket2->add('R01');
printBasket($basket2, $catalog);

// Test Case 3: Multiple products, medium delivery
echo "Test Case 3: Multiple products, medium delivery (over $50 and under $90)<br>";
$basket3 = new Basket($catalog, $deliveryRules, $offers);
$basket3->add('R01');
$basket3->add('G01');
printBasket($basket3, $catalog);

// Test Case 4: Complex basket with multiple products and offers (over $90)
echo "Test Case 4: Complex basket with multiple products and offers (over $90)<br>";
$basket4 = new Basket($catalog, $deliveryRules, $offers);
$basket4->add('B01');
$basket4->add('B01');
$basket4->add('R01');
$basket4->add('R01');
$basket4->add('R01');
printBasket($basket4, $catalog);
