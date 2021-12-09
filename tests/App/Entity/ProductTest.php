<?php

namespace tests\App\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;

class ProductTest extends TestCase
{
    /**
     * @dataProvider pricesForFoodProduct
     */
    public function testcomputeTVAFoodProduct($price, $expectedTva)
    {
        $product = new Product('Un produit', Product::FOOD_PRODUCT, $price);

        $this->assertSame($expectedTva, $product->computeTVA());
    }

    public function pricesForFoodProduct()
    {
        return [
            [0, 0.0],
            [20, 1.1],
            [100, 5.5]
        ];
    }

    public function testcomputeTVAOtherProduct()
    {
        $product = new Product('le produit', 'Salade', 20);

        $this->assertSame(3.92, $product->computeTVA());
    }

    public function testNegativePriceComputeTVA()
    {
        $product = new Product('Un produit', Product::FOOD_PRODUCT, -20);

        $this->expectException('LogicException');

        $product->computeTVA();
    }

    

}