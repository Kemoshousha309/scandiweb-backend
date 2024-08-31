<?php

declare(strict_types=1);


namespace App\Models;

abstract class Product
{
    private string $SKU;
    private string $name;
    private float $price;

    public function __construct(string $SKU, string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
        $this->SKU = $SKU;
    }

    // Getters 
    public function getSKU(): string
    {
        return $this->SKU;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    // Setters 
    // we can implement our restrictions on setting the data as we want
    //  (for modification after creation) 

    public function setSKU(string $SKU): void
    {
        $this->SKU = $SKU;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}
