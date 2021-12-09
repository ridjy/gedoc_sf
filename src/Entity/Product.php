<?php

namespace App\Entity;

class Product
{
    const FOOD_PRODUCT = 'food';

    private $name;

    private $type;

    private $price;

    public function __construct($name, $type, $price)
    {
        $this->name = $name;
        $this->type = $type;
        $this->price = $price;
    }

    public function computeTVA()
    {
        if (self::FOOD_PRODUCT == $this->type) {
            return $this->price * 0.055;
        }

        if ($this->price < 0) {
            throw new \LogicException('The TVA cannot be negative.');
        }

        return $this->price * 0.196;
    }
}