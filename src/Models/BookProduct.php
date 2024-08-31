<?php

declare(strict_types=1);

namespace App\Models;

class BookProduct extends Product
{

    public function __construct(string $SKU, string $name, float $price)
    {
        parent::__construct($SKU, $name, $price);
    }
}
