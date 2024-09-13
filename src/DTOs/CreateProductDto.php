<?php

// DTO => send and receive data form front
// dto => Data Transfer object 
// as an encapsulation for data to transfer between different layers 
declare(strict_types=1);

namespace App\DTOs;

class CreateProductDto
{
    // these fields should be final as a best practice
    private string $type;
    private string $SKU;
    private string $name;
    private float $price;
    private float $weight;
    private float $size;
    private array $dimensions;

    public function __construct($type, $SKU, $name, $price, $weight,  $size, $dimensions)
    {
        $this->type = $type;
        $this->name = $name;
        $this->SKU = $SKU;


        // Use floatval() to ensure the value is treated as a float or provide default if empty
        $this->price = !empty($price) && is_numeric($price) ? floatval($price) : 0;
        $this->weight = !empty($weight) && is_numeric($weight) ? floatval($weight) : 0;
        $this->size = !empty($size) && is_numeric($size) ? floatval($size) : 0;

        // Convert dimensions to an array, ensure it's properly parsed
        $this->dimensions = is_array($dimensions) ? $dimensions : [];
    }

    // Getters 
    public function getSKU(): string
    {
        return $this->SKU;
    }
    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getSize(): float
    {
        return $this->size;
    }

    public function getDimensions(): array
    {
        return $this->dimensions;
    }
}
