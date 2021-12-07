<?php

namespace tests\App\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;

class ProductTest extends TestCase
{
    public function testcomputeTVAFoodProduct()
    {
        $product = new Product('Un produit', Product::FOOD_PRODUCT, 20);

        $this->assertSame(1.1, $product->computeTVA());
    }

    public function testcomputeTVAOtherProduct()
    {
        $product = new Product('le produit', 'Salade', 20);

        $this->assertSame(3.92, $product->computeTVA());
    }
}